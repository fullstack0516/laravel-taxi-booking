<?php

namespace App\Models;

use App\Notifications\VerifyApiEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use Notifiable;
    use HasRoleAndPermission;
    use Billable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'driver_license',
        'password',
        'signup_ip_address',
        'signup_confirmation_ip_address',
        'updated_ip_address',
        'deleted_ip_address',
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
        'phone_verified_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function hasVerifiedPhone()
    {
        return ! is_null($this->phone_verified_at);
    }

    public function isApproved()
    {
        return ! is_null($this->approved_at);
    }

    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function callToVerify()
    {
        $code = random_int(100000, 999999);

        $this->forceFill([
            'verification_code' => $code
        ])->save();

        try {
            $client = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
            $client->calls->create(
                $this->phone_number,
                "+16503000347", // REPLACE WITH YOUR TWILIO NUMBER
                ["url" => "https://youwala.com/build-twiml/{$code}"]
            );
        } catch (ConfigurationException $e) {

        }
    }

    public function smsToVerify()
    {
        $code = random_int(100000, 999999);

        $this->forceFill([
            'verification_code' => $code
        ])->save();

        $client = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        $client->messages->create(
            $this->phone_number,
            array(
                'body' => 'Hi, thanks for Joining to Youwala. Verification code: '.$this->verification_code,
                'from' => "+16503000347",
            )
        );
    }

    public function sendApiEmailVerificationNotification()
    {
        $this->notify(new VerifyApiEmail);
    }

    public function social()
    {
        return $this->hasOne('App\Models\Social');
    }

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    public function car()
    {
        return $this->hasOne('App\Models\Car', 'driver_id');
    }

    public function stripeAccount()
    {
        return $this->hasOne('App\Models\StripeAccount', 'user_id');
    }

    public function myRides()
    {
        return $this->hasMany('App\Models\Ride', 'owner_id');
    }

    public function bids()
    {
        return $this->hasMany('App\Models\Bid', 'driver_id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review', 'author_id');
    }

    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }

    public function currentLocation()
    {
        return $this->hasOne('App\Models\DriverLocation', 'driver_id');
    }

    public function cities()
    {
        return $this->belongsToMany('App\Models\City');
    }
}
