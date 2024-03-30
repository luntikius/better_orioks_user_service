<?php

use App\Console\Commands\CheckUsers;
use Illuminate\Support\Facades\Artisan;

Artisan::command('check', function () {
    $cu = new CheckUsers();
    $cu -> invoke();
})
    ->purpose('Check Users')
    ->everyFifteenMinutes();


