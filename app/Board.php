<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = ['title', 'content', 'user_id'];
    // ㅇ

    //보드 입장에서는 게시글을 작성한 사람은 단일 1명 이니까 uesrs가 아니라 user로..
    public function user(){
      return $this->belongsTo(User::class);
    }

    // 보드는 또한 코멘트에서 여러개의 답글이 달릴 수 있으므로 복수..
    public function comments(){
      return $this->hasMany(Comment::class);
    }

    public function attachments(){
      return $this->hasMany(Attachment::class);
    }
}
