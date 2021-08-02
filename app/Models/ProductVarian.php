<?php

namespace App\Models;

use App\Events\StockUpdate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Listeners\CreateStockHistory;
class ProductVarian extends Model
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
    protected $appends = ['price', 'price_rupiah', 'full_name', 'status', 'weight'];
    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => StockUpdate::class,
    ];

    /**
     * Get the product that owns the ProductVarian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get all of the inboundStock for the ProductVarian
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inboundStock()
    {
        return $this->hasMany(InboundStock::class);
    }

    /**
     * Get the price
     *
     * @param  string  $value
     * @return string
     */
    public function getPriceAttribute()
    {
        return $this->product->price;
    }

    /**
     * Get the price rupiah
     *
     * @param  string  $value
     * @return string
     */
    public function getPriceRupiahAttribute()
    {
        return $this->product->price_rupiah;
    }

    /**
     * Get the name
     *
     * @param  string  $value
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->product->name.' - '.$this->name;
    }

    /**
     * Get the statis
     *
     * @param  string  $value
     * @return string
     */
    public function getStatusAttribute()
    {
        return $this->product->status;
    }

    /**
     * Get the weight
     *
     * @param  string  $value
     * @return string
     */
    public function getWeightAttribute()
    {
        return $this->product->weight;
    }
}
