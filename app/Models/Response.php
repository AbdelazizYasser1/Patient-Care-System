<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Response extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'question_id',
        'doctor_id',
        'response_text'
    ];
    
}
