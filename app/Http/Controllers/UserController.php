<?php

namespace App\Http\Controllers;

use App\Models\OrioksUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function registerAUser (Request $request): string
    {
        $userData = $request -> validate([
            'id' => 'required',
            'authString' => 'required',
            'isReceivingPerformanceNotifications' => 'required',
            'isReceivingNewsNotifications' => 'required'
            ]);
        $userData['authString'] = bcrypt($userData['authString']);
        $userData['last_news_id'] = -1;

        $user = OrioksUser::create($userData);
        return("BOBS");
    }
}
