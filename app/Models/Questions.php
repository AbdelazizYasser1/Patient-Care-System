<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Questions extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'question_text',
        'patient_id',
        'doctor_id',
        'status'
    ];

    public function Answers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Response::class);
    }
}
