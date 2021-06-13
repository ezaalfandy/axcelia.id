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
        return Carbon::parse($this->created_at)->translatedFormat('D, d F Y');;
    }
}
