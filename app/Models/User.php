<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','introduction','avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
    //用户与话题中间的关系是 一对多 的关系，一个用户拥有多个主题，
    //在 Eloquent 中使用 hasMany() 方法进行关联。关联设置成功后，
    //我们即可使用 $user->topics 来获取到用户发布的所有话题数据。
}
