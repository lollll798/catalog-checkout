<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id');
            $table->foreignId('order_purchase_id')->nullable()->default(null);
            $table->integer('product_id');
            $table->integer('branch_id')->default(0);
            $table->integer('status')->default(0);
            $table->integer('qty')->default(0);
            $table->double('unit_price', 18, 4)->default(0.0000);
            $table->double('item_price', 18, 4)->default(0.0000);
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
        Schema::dropIfExists('items');
    }
}
