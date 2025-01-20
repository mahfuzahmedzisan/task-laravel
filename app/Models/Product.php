<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'price', 'category_id', 'image'];

    /**
     * Define the relationship with the Category model.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Define the many-to-many relationship with Cart via the pivot table.
     */
    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'carts_products')
                    ->withPivot('quantity') // Include the quantity column from the pivot table
                    ->withTimestamps();    // Include timestamps from the pivot table
    }
}
