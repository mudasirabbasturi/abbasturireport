<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name', 
        'father_name', 
        'phone_number', 
        'reference_number', 
        'email', 
        'password',
        'country', 
        'state', 
        'city', 
        'permanent_address', 
        'current_address', 
        'id_card', 
        'document',
        'profile_picture', 
        'type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */

     protected function type(): Attribute {
         return new Attribute(
             get: fn ($value) =>  ["employee", "admin"][$value],
         );
     }

     public function actions() {
         return $this->hasMany(Action::class);
     }

}
