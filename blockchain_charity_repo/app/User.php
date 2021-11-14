<?php

namespace App;

use App\Notifications\PasswordReset;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    protected $primaryKey = 'user_address';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_address','name', 'email', 'password', 'role', 'home_address', 'phone', 'wallet_type',
        'private_key', 'amount_of_money', 'otp_code', 'otp_expires_at', 'image_card_front', 'image_card_back'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','private_key'
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
        $this->otp_expires_at = now()->addMinutes(60);
        $this->save();
        return $this->otp_code;
    }

    public function resetOtp()
    {
        $this->otp_code = null;
        $this->otp_expires_at = null;
        $this->otp_verified_at = null;
        return $this->save();
    }

    // send email reset password
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token));
    }
}