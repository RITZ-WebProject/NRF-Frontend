<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderedProductsSqlite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlite')->create('ordered_products', function ($table) {
            $table->id();
            $table->string('invoice_id');
            $table->string('customer_id');
            $table->string('product_id');
            $table->string('price');
            $table->string('merchant_order_id');
            $table->string('prepay_id');
            // $table->integer('quantity');
            $table->string('size');
            // $table->boolean('on_discount')->nullable();
            $table->string('status');
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
        Schema::connection('sqlite')->dropIfExists('ordered_products');
    }
}
