<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * Get the product that owns the PurchaseDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productVarian()
    {
        return $this->belongsTo(ProductVarian::class);
    }

    /**
     * Get the purchase that owns the PurchaseDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['price_rupiah', 'total_price_rupiah_no_discount', 'total_discount_rupiah'];

    /**
     * Get the Price Rupiah
     *
     * @param  string  $value
     * @return string
     */
    public function getPriceRupiahAttribute()
    {
        return 'Rp '.number_format($this->productVarian->price, 0, ".", ".");
    }
    /**
     * Get the total harga
     *
     * @param  string  $value
     * @return string
     */
    public function getTotalPriceRupiahAttribute()
    {
        return 'Rp '.number_format((intval($this->productVarian->price) * intval($this->quantity)) - (intval($this->discount) * intval($this->quantity)), 0, ".", ".");
    }


    /**
     * Get the total harga
     *
     * @param  string  $value
     * @return string
     */
    public function getTotalPriceAttribute()
    {
        return (intval($this->productVarian->price) * intval($this->quantity)) - (intval($this->discount) * intval($this->quantity));
    }

    /**
     * Get the total harga
     *
     * @param  string  $value
     * @return string
     */
    public function getTotalPriceNoDiscountAttribute()
    {
        return (intval($this->productVarian->price) * intval($this->quantity));
    }

    /**
     * Get the total harga
     *
     * @param  string  $value
     * @return string
     */
    public function getTotalPriceRupiahNoDiscountAttribute()
    {
        return 'Rp '.number_format((intval($this->productVarian->price) * intval($this->quantity)), 0, ".", ".");
    }

    /**
     * Get the TOtal discount
     *
     * @param  string  $value
     * @return string
     */
    public function getTotalDiscountRupiahAttribute()
    {
        return 'Rp '.number_format((intval($this->discount) * intval($this->quantity)), 0, ".", ".");
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
