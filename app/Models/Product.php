<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    use HasFactory;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */

     public static function booted(){
        static::addGlobalScope('latest', function(Builder $builder){
            $builder->orderBy('created_at', 'DESC');
        });
     }

     /**
      * The accessors to append to the model's array form.
      *
      * @var array
      */
     protected $appends = ['image_url', 'price_rupiah', 'stock'];
    /**
     * Get the Price
     *
     * @param  string  $value
     * @return string
     */
    public function getPriceRupiahAttribute()
    {
        return 'Rp '.number_format($this->price, 0, ".", ".");
    }

    /**
     * Get the Image URL
     *
     * @param  string  $value
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/products').'/'.$this->image;
    }

    /**
     * Get the Stock
     *
     * @param  string  $value
     * @return string
     */
    public function getStockAttribute()
    {
        return $this->productVarian()->sum('stock');
    }
    /**
     * Get all of the shoppingCart for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shoppingCart()
    {
        return $this->hasMany(ShoppingCart::class, 'product_id', 'id');
    }


    /**
     * Get all of the purchaseDetail for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseDetail()
    {
        return $this->hasMany(purchaseDetail::class, 'product_id', 'id');
    }

    /**
     * Get all of the productVarian for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productVarian()
    {
        return $this->hasMany(ProductVarian::class);
    }


}
