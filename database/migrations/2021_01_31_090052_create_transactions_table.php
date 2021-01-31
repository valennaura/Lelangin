<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('method');
            $table->string('account');
            $table->decimal('total');
            $table->char('province_id');
            $table->foreign('province_id')->references('id')->on('indonesia_provinces')->onDelete('cascade');
            $table->char('city_id');
            $table->foreign('city_id')->references('id')->on('indonesia_cities')->onDelete('cascade');
            $table->char('district_id');
            $table->foreign('district_id')->references('id')->on('indonesia_districts')->onDelete('cascade');
            $table->char('village_id');
            $table->foreign('village_id')->references('id')->on('indonesia_villages')->onDelete('cascade');
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
        Schema::dropIfExists('transactions');
    }
}
