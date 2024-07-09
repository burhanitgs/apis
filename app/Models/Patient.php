<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
//use App\Notifications\VerifyEmail;
use App\Notifications\VerifyApiEmail;
class Patient extends Authenticatable implements MustVerifyEmail
{
    //use HasApiTokens, HasFactory, Notifiable;
	use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
		'first_name',
		'middle_name',
		'last_name',
		'phone_number',
		'address',
		'date_of_birth',
        'password',
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
        'password' => 'hashed',
    ];
	public function sendApiEmailVerificationNotification()
	{
		$this->notify(new VerifyApiEmail); // my notification
	}
}
