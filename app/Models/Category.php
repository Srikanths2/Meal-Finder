<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    // public function foodCategories()
    // {
    //     return $this->hasMany(FoodCategory::class, 'category_id', 'id');
    //     // categories.name → food_categories.categories
    // }
    public function foodCategories()
    {
        return $this->hasMany(Product::class, 'category_id', 'id'); // correct usage
    }
}
