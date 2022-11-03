<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Models\Traits\AutoWhereScope;
use App\Models\Traits\AutoWithScope;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, AutoWhereScope, AutoWithScope;

    protected $filtarable = ['username', 'role', 'disabled'];

    public const ROLE_DEVELOPER = 'developer';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_MODERATOR = 'moderator';
    public const ROLE_USER = 'user';

    public const ROLES = [
        self::ROLE_ADMIN, self::ROLE_MODERATOR, self::ROLE_USER, self::ROLE_DEVELOPER
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'uuid',
        'role',
        'disabled',
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
        'logins' => 'array'
    ];

    public function getFilterable(): array
    {
        return $this->filtarable;
    }

    public function userClub()
    {
        return $this->hasOne(Club::class);
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected static function addLoginRecord($user){
        $logins = (array) $user->logins;
        $ip = date("Y-m-d H:i:s", time()) . '~' . 'IP : ' . self::getUserIpAddr();
        array_unshift($logins, $ip);
        $new_array  = array_slice($logins, 0 , 19);
        $user->logins = $new_array;
        $user->save();
    }

    private static function getUserIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}
