<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('self_take')->default(0);
            $table->string('total_cost', 100);
            $table->text('payment_receipt')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('subdistrict')->nullable();
            $table->text('address')->nullable();
            $table->string('courier', 100)->nullable();
            $table->string('courier_cost', 100)->nullable();
            $table->string('receipt_number', 100)->nullable();
            $table->string('total_weight', 100)->nullable();
            $table->enum('status', ['complete', 'waiting_payment', 'waiting_confirmation'])->default('waiting_payment');
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
        Schema::dropIfExists('purchases');
    }
}
