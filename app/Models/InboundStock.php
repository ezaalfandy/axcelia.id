<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class InboundStock extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(function($query){
            $query->orderBy('id', 'DESC');
        });
    }
    /**
     * Get the productVarian that owns the InboundStock
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productVarian()
    {
        return $this->belongsTo(ProductVarian::class);
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

}
