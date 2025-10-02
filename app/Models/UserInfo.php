<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'country',
        'fname',
        'lname',
        'email',
        'company',
        'phone',
        'address',
        'street',
        'state',
        'zip_code',
        'message',
    ];
    
}
