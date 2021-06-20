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
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * Get the total harga
     *
     * @param  string  $value
     * @return string
     */
    public function getTotalPriceRupiahAttribute()
    {
        return 'Rp '.number_format((intval($this->product->price) * intval($this->quantity)), 0, ".", ".");
    }


    /**
     * Get the total harga
     *
     * @param  string  $value
     * @return string
     */
    public function getTotalPriceAttribute()
    {
        return intval($this->product->price) * intval($this->quantity);
    }
}
