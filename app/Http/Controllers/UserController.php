<?php

namespace App\Http\Controllers;

use App\Models\OrioksUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function registerAUser (Request $request)
    {
        $userData = $request -> validate([
            'id' => 'required',
            'auth_string' => 'required',
            'is_receiving_performance_notifications' => 'required',
            'is_receiving_news_notifications' => 'required',
            ]);
        $userData['last_news_id'] = -1;
        
        OrioksUser::create($userData);
        return view("welcome");
    }

}
