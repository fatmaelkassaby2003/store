<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'old_price',
        'image',
        'type',
        'category',
        'content',
        'code',
        'size',
        'quantity',
        'company_id'
        // أي حقول أخرى تريد السماح بتعيينها
    ];
    
    public function company()
{
    return $this->belongsTo(Company::class, 'company_id')->withDefault();
}

public function orders()
{
    return $this->belongsToMany(Order::class, 'order_products', 'product_id', 'order_id');

}

}
