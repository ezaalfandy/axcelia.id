<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInboundStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inbound_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_varian_id');
            $table->foreign('product_varian_id')->references('id')->on('product_varians')->onDelete('cascade');
            $table->integer('stock_change')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inbound_stocks');
    }
}
