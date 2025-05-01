<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Define the table name (optional if the table name is the plural form of the model)
    protected $table = 'products'; // Assuming the table name is 'products'

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'category_id',
        'name',
        'image',
        'description',
        'amount',
        'active',
    ];

    // Relationship: A FoodCategory has many DetailsOfFood
    // public function detailsOfFood()
    // {
    //     return $this->hasMany(DetailsOfFood::class, 'category_id'); // Assuming 'category_id' is the foreign key
    // }
    // public function category()
    // {
    //     return $this->belongsTo(Category::class, 'id', 'category_id');
    //     // food_categories.categories → categories.name
    // }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id'); // was wrong earlier
    }
}
