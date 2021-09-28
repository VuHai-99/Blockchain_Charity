<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'address', 'phone', 'public_key', 'private_key', 'coin', 'otp_code', 'otp_expires_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function generateOtp()
    {
        $this->otp_code = rand(100000, 999999);
        $this->otp_expires_at = now()->addMinutes(20);
        $this->save();
        return $this->otp_code;
    }

    public function resetOtp()
    {
        $this->otp_code = null;
        $this->otp_expires_at = null;
        return $this->save();
    }
}
