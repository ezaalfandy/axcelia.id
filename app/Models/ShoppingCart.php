<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ShoppingCart extends Model
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
    protected $appends = ['price'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */

    /**
     * Get the product that owns the ShoppingCart
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productVarian()
    {
        return $this->belongsTo(ProductVarian::class);
    }

    /**
     * Get the user that owns the ShoppingCart
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the FormattedCreatedDate
     *
     * @param  string  $value
     * @return string
     */
    public function getFormattedCreatedDateAttribute()
    {
        return Carbon::parse($this->created_at)->translatedFormat('D, d F Y G:i');
    }

    /**
     * Get the price
     *
     * @param  string  $value
     * @return string
     */
    public function getPriceAttribute()
    {
        return $this->productVarian->price;
    }
}
