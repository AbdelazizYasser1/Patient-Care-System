<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class medical_history extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'Name_of_Surgey',
        'Description_of_Surgey',
        'user_id'
    ];

    public function patient()
    {
        return $this->belongsTo(User::class);
    }
}

