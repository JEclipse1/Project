<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
  protected $fillable = ['filename','bytes','mine'];
    public function infos(){
        return $this->belongsTo(Board::class);
    }

}
