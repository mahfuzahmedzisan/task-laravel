<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    /**
     * Define the relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define the relationship with the CartProduct pivot table.
     */
    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class);
    }

    /**
     * Define the many-to-many relationship with Product via the pivot table.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'carts_products')
                    ->withPivot('quantity') // Include the quantity column from the pivot table
                    ->withTimestamps();    // Include timestamps from the pivot table
    }
}
