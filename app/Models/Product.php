<?php

namespace App\Models;

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
        return secure_asset('storage/product').'/'.$this->image;
    }
}
