<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('po_no');
            $table->integer('status')->default(1);
            $table->double('subtotal_price', 18, 4)->default(0.0000);
            $table->double('discount_price', 18, 4)->default(0.0000);
            $table->double('shipping_price', 18, 4)->default(0.0000);
            $table->double('total_price', 18, 4)->default(0.0000);
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
        Schema::dropIfExists('order_purchases');
    }
}
