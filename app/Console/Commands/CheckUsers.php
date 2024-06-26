<?php

namespace App\Console\Commands;

use App\Models\OrioksScore;
use App\Models\OrioksUser;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

const parserLink = "http://25.47.206.7/api/v1";
const notificationLink = "http://25.46.243.50/api/v1";
class CheckUsers
{
    public function invoke(): void
    {
        echo "STARTED USER CHECK";
        $users = OrioksUser::all();
        foreach ($users as $user){
            $this->checkUser($user);
        }
    }

    private function checkUser (OrioksUser $user): void
    {
        if($user -> is_receiving_performance_notifications){
            echo "\nSTARTED PERFORMANCE CHECK FOR USER ".$user->id." ...";
            $this->checkUserPerformance($user);
            echo "\nFINISHED PERFORMANCE CHECK";
        }
        if($user -> is_receiving_news_notifications){
            echo "\nSTARTED NEWS CHECK FOR USER ".$user->id." ...";
            $this->checkUserNews($user);
            echo "\nFINISHED NEWS CHECK";
        }
    }

    private function checkUserPerformance(OrioksUser $user): void
    {
        $currentUserScore =
            OrioksScore::select('subject_id','subject_name','control_event_id','control_event_name','user_score')
            -> where('user_id',$user -> user_id)
            -> get();

        $newUserScore = $this->sendPerformanceGetRequest($user);

        if($newUserScore != null && count($currentUserScore) == count($newUserScore)){
            $changes = [];
            for($i = 0; $i < count($currentUserScore); $i++){
                if($currentUserScore[$i]->user_score != $newUserScore[$i]->user_score){
                    $changes[] = [
                        'user_id' => $user -> id,
                        'subject_name' => $currentUserScore[$i] -> subject_name,
                        'control_event_name' => $currentUserScore[$i] -> control_event_name,
                        'current_score' => $currentUserScore[$i] -> user_score,
                        'new_score' => $newUserScore[$i] -> user_score,
                    ];
                    $this->notifyPerformanceChanges($changes);
                }
            }
        }

        if($newUserScore != null) $this->updateUsersPerformance($user, $newUserScore);
        
    }

    private function updateUsersPerformance(OrioksUser $user, array $newUserScore): void
    {
        OrioksScore::where('user_id',$user -> id) -> delete();

        foreach ($newUserScore as $score){
            $os = $this->getOrioksScore($user->id, $score);
            $os -> save();
        }
    }

    private function notifyPerformanceChanges (array $changes): void
    {
        $data = json_encode($changes);
        $request = Http::withBody($data) -> post(notificationLink."/notifications");
        if($request -> successful()){
            echo ("\nPerformance notification sent: ".$request -> json());
        }
    }

    private function sendPerformanceGetRequest(OrioksUser $user): ?array
    {
        $encrypted = Crypt::encrypt($user -> auth_string);
        $parameters = ['Auth-String' => $encrypted];
        $request = Http::withQueryParameters($parameters)->get(parserLink."/marks");

        if($request -> successful()){
            $identity = $request -> header('identity');
            $newAuthString = $identity."; ".(explode("; ",$user -> auth_string)[1]);
            $user -> auth_string = $newAuthString;
            $user -> save();
            $json = $request -> json();
            $decoded = json_decode($json,true);

            $scoreArray = [];

            foreach ($decoded as $dec){
                $orioksScore = $this->getOrioksScore($user -> id, $dec);
                $scoreArray[] = $orioksScore;
            }
            return $scoreArray;
        }else{
            $errorCode = $request -> status();
            echo("\nUSER CHECK FOR ".$user->id." FAILED ON PERFORMANCE WITH ERROR ".$errorCode);
            return null;
        }
    }


    private function checkUserNews(OrioksUser $user): void
    {
        $encrypted = Crypt::encrypt($user -> auth_string);
        $parameters = ['Auth-String' => $encrypted];
        $request = Http::withQueryParameters($parameters)->get(parserLink."/news");
        if($request -> successful()){
            $parsed = json_decode($request -> json(), true);
            $newId = $parsed['id'];
            if($newId != $user -> last_news_id){
                $this->notifyNews($user,$parsed['name'],$parsed['url']);
                $user->last_news_id = $newId;
                $user->save();
            }
        }else{
            $errorCode = $request -> status();
            echo("\nUSER CHECK FOR ".$user->id." FAILED ON NEWS WITH ERROR ".$errorCode);
        }
    }

    private function notifyNews(OrioksUser $user, string $name, string $url): void
    {
        $data = json_encode(['user_id' => $user -> id,'NewsName' => $name,'link' => $url]);
        $request = Http::withBody($data) -> post(notificationLink."/news");
        if($request -> successful()){
            echo ("\nNews notification sent: ".$request -> json());
        }
    }

    private function getOrioksScore(int $userId, Mixed $dec): OrioksScore
    {
        $orioksScore = new OrioksScore();
        $orioksScore->user_id = $userId;
        $orioksScore->subject_id = $dec['subject_id'];
        $orioksScore->subject_name = $dec['subject_name'];
        $orioksScore->control_event_id = $dec['control_event_id'];
        $orioksScore->control_event_name = $dec['control_event_name'];
        $orioksScore->user_score = $dec['user_score'];

        return $orioksScore;
    }
}
