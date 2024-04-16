<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrioksUser extends Model
{
    use HasFactory;

    protected $fillable = [ 'id', 'auth_string', 'last_news_id', 'is_receiving_performance_notifications', 'is_receiving_news_notifications' ];


}
