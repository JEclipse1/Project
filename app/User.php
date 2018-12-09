<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // 이 부분은 유저가 많은 게시글을 가지고 있으니까.. 보드 테이블에서 뽑아내기 위해서 쓴거임
    public function boards(){
      return $this->hasMany(Board::class);    // 하나의 유저는 보드에 있어서 많은 것을 가지고 있으므로 hasMany.. 유저 하나당 - 많은 보드
    }

    public function comments(){
      return $this->hasMany(Comment::class);    // 하나의 유저는 보드에 있어서 많은 것을 가지고 있으므로 hasMany.. 유저 하나당 - 많은 보드
    }
}
