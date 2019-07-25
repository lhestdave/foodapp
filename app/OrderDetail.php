<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
  protected $fillable = [
    'orderid', 'menuitemsid', 'quantity','amount'
    ];
}
