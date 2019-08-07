<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    public function destination() {
      return $this->belongsTo('App\Destination', 'destination_id');
    }
}
