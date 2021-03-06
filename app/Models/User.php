<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //定义需要交互的数据库
    protected $table = 'users';

    //gravatar
    /**
     * @var mixed
     */

    public function gravatar($size='100')
    {
        $hash=md5(strtolower(trim($this->attributes['email'])));
        return "https://www.gravatar.com/avatar/$hash?s=$size";
    }

    /*
     * 添加监听的creating()方法
     * */
    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(function ($user)
        {
            $user->activation_token = Str::random(10);
        });
    }

    /*
     * 建立一个User对多个Status的模型关系
     * */
/*    public function statuses()
    {
        return $this->hasMany(Statuses::class);
    }*/
}
