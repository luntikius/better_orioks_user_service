<?php

use App\Console\Commands\CheckUsers;
use App\Models\OrioksUser;
use Illuminate\Support\Facades\Artisan;

Artisan::command('check', function () {
    $cu = new CheckUsers();
    $cu -> invoke();
})
    ->purpose('Check Users')
    ->everyFifteenMinutes();

Artisan::command('delete_users', function (){
    OrioksUser::where(true) -> delete();
});

