<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class XRay extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'Name_of_XRay',
        'Description_of_XRay',
        'Result_of_XRay',
        'type_of_XRay',
        'image_of_XRay',
        'user_id'
    ];

}
