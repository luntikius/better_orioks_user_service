<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrioksScore extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'subject_id',
        'subject_name',
        'control_event_id',
        'control_event_name',
        'user_score',
    ];
    protected $primaryKey = ['user_id','subject_id','control_event_id'];

    public $incrementing = false;
}
