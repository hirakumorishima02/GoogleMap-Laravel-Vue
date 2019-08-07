<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    public function memoToDestination() {
      return $this->hasMany('App\Memo', 'destination_id');
    }
}
