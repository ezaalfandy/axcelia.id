<?php

namespace App\Events;

use App\Models\ProductVarian;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockUpdate
{
    use Dispatchable, SerializesModels;

    public $productVarian;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ProductVarian $productVarian)
    {
        $this->productVarian = $productVarian;
    }

}
