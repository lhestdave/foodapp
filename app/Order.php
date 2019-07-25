<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Order extends Model
{
  protected $fillable = [
    'userid', 'subtotal', 'discount','couponcode','total','isFinal'
    ];
}
