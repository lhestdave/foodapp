<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('orderid');
            $table->unsignedBigInteger('menuitemsid');
            $table->unsignedInteger('quantity');
            $table->decimal('amount', 8, 2);
            $table->timestamps();
            $table->foreign('orderid')->references('id')->on('orders');
            // $table->foreign('menuitemsid')->references('id')->on('menuitems');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
