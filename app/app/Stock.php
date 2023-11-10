<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public function item() {
        return $this->belongsTo('App\Item', 'item_id', 'id');
    }

    public function store() {
        return $this->belongsTo('App\Store', 'store_id', 'id');
    }
}
