<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone_number',
        'alternate_phone',
        'address',
        'city',
        'state',
        'pincode',
        'total_amount',
        'payment_method',
        'payment_status',
        'order_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}
