<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phonenumber',
        'alternate_phone',
        'address',
        'city',
        'state',
        'pincode',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
