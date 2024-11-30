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
        'image',
        'category_id',
        'is_active'
    ];

    // Define the relationship: A product belongs to one category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    // In Product model
    public function discounts()
    {
        return $this->hasMany(Discount::class); // Or use belongsToMany if the relationship is many-to-many
    }
}
