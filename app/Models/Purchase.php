<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class Purchase extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['total_items', 'formatted_total_weight', 'total_cost_rupiah_no_discount', 'total_discount_rupiah', 'full_address'];

    /**
     * Get all of the purchase_detail for the Purchase
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchase_details()
    {
        return $this->hasMany(PurchaseDetail::class, 'purchase_id', 'id');
    }

    /**
     * Get the user associated with the Purchase
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get the FormattedPurchaseDate
     *
     * @param  string  $value
     * @return string
     */
    public function getFormattedPurchaseDateAttribute()
    {
        return Carbon::parse($this->created_at)->translatedFormat('d/M/Y');;
    }

    /**
     * Get the total cost
     *
     * @param  string  $value
     * @return string
     */
    public function getTotalCostRupiahAttribute()
    {
        return 'Rp '.number_format($this->total_cost, 0, ".", ".");
    }

    /**
     * Get the Total Cost No Discount
     *
     * @param  string  $value
     * @return string
     */
    public function getTotalCostRupiahNoDiscountAttribute()
    {
        $total_cost = 0;
        foreach ($this->purchase_details as $item)
        {
            $total_cost += (intval($item->productVarian->price) * intval($item->quantity));
        }

        return 'Rp '.number_format($total_cost, 0, ".", ".");
    }

    /**
     * Get the Total Cost No Discount No Courier
     *
     * @param  string  $value
     * @return string
     */
    public function getTotalCostRupiahNoDiscountNoCourierAttribute()
    {
        $total_cost = 0;
        foreach ($this->purchase_details as $item)
        {
            $total_cost += (intval($item->productVarian->price) * intval($item->quantity));
        }

        return 'Rp '.number_format($total_cost - $this->courier_cost, 0, ".", ".");
    }


    /**
     * Get the Total Cost No Discount No Courier
     *
     * @param  string  $value
     * @return string
     */
    public function getTotalCostRupiahNoCourierAttribute()
    {
        return 'Rp '.number_format($this->total_cost - $this->courier_cost, 0, ".", ".");
    }


    /**
     * Get the Total Discount
     *
     * @param  string  $value
     * @return string
     */
    public function getTotalDiscountRupiahAttribute()
    {
        $total_discount = 0;
        foreach ($this->purchase_details as $item)
        {
            $total_discount += (intval($item->discount) * intval($item->quantity));
        }

        return 'Rp '.number_format($total_discount, 0, ".", ".");
    }

    /**
     * Get the courier cost
     *
     * @param  string  $value
     * @return string
     */
    public function getCourierCostRupiahAttribute()
    {
        return 'Rp '.number_format($this->courier_cost, 0, ".", ".");
    }

    /**
     * Get the Formatted Total Weight
     *
     * @param  string  $value
     * @return string
     */
    public function getFormattedTotalWeightAttribute()
    {
        $total_weight = $this->total_weight;
        if ($total_weight > 1000) {
            return (floatval($total_weight) / 1000).' Kg';
        }else{
            return $total_weight.' gram';
        }
    }

    /**
     * Get the Total Items
     *
     * @param  string  $value
     * @return string
     */
    public function getTotalItemsAttribute()
    {
        $total_items = 0;
        foreach ($this->purchase_details as $item)
        {
            $total_items += intval($item->quantity);
        }
        return $total_items;
    }

    /**
     * Get the Created At
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::parse($created_at)->translatedFormat('D, d F Y G:i');
    }

    /**
     * Get the Full Address
     *
     * @param  string  $value
     * @return string
     */
    public function getFullAddressAttribute()
    {
        return $this->address.' '.$this->subdistrict.', '.$this->city.' - '.$this->province;
    }
}
