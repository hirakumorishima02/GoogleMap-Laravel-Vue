<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    public function memos() {
      return $this->hasMany('App\Memo', 'destination_id');
    }
}
