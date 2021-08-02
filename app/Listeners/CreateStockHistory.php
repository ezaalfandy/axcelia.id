<?php

namespace App\Listeners;

use App\Events\StockUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\InboundStock;

class CreateStockHistory
{
    public $afterCommit = true;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  StockUpdate  $event
     * @return void
     */
    public function handle(StockUpdate $event)
    {
        if($event->productVarian->wasRecentlyCreated)
        {
            $inboundStock = new InboundStock([
                'product_varian_id' => $event->productVarian->id,
                'stock_change' => $event->productVarian->stock
            ]);
            $inboundStock->save();
        }else
        {
            if($event->productVarian->isDirty('stock'))
            {
                $inboundStock = new InboundStock();
                $inboundStock->product_varian_id = $event->productVarian->id;
                // [
                //     'product_varian_id' => $event->productVarian->id,
                //     'stock_change' => $event->productVarian->stock - $event->productVarian->getOriginal('stock')
                // ]
                $inboundStock->stock_change = $event->productVarian->stock - $event->productVarian->getOriginal('stock');
                $inboundStock->save();
            }
        }
    }
}
