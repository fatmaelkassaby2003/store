<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'total_price'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // App\Models\Order.php
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userInfo()
    {
        return $this->hasOne(UserInfo::class, 'user_id', 'user_id');
    }


}
