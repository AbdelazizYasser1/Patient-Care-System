<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use  HasApiTokens , HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'FullName',
        'email',
        'password',
        'phone',
        'gender',
        'usertype',
        'age',
        'NationalID',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function Medical_history(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Medical_history::class);
    }
    public function XRay(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(XRay::class);
    }
    public function Questions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Questions::class);
    }
    public function responses()
    {
        return $this->hasMany(Response::class, 'question_id');
    }
}
