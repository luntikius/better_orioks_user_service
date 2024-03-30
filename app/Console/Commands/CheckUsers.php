<?php

namespace App\Console\Commands;

use App\Models\OrioksUser;

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
            $this->checkUserPerformance($user);
        }
        if($user -> is_reveiving_news_notifications){
            $this->checkUserNews($user);
        }
    }

    private function checkUserPerformance(OrioksUser $user): void
    {
        $user -> auth_string = $user -> auth_string.'1';
        $user -> save();
        //
    }

    private function checkUserNews(OrioksUser $user): void
    {
       //
    }
}
