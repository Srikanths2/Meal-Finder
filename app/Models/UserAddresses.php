<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAddresses extends Model
{
    use HasFactory;
    protected $table = 'user_addressess'; // Updated table name

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
