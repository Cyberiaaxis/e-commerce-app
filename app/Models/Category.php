<?php

// app/Models/Category.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
            'category_name'
        ];
    // Define the relationship: A category can have many products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
