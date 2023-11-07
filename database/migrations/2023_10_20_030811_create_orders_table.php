<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('code', 15)->primary();
            $table->unsignedBigInteger('cid');
            $table->foreign('cid')->references('id')->on('users')->onDelete('cascade');
            $table->string('email');
            $table->string('phone');
            $table->string('product_code');
            $table->foreign('product_code')->references('code')->on('products')->onDelete('cascade');
            $table->integer('qty');
            $table->float('summary_price');
            $table->text('delivery_address');
            $table->text('billing_address');
            $table->timestamps();
            $table->index(['code', 'cid', 'product_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
