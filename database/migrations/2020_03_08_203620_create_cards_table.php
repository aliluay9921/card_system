<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->integer('amount_id')->references('id')->on('amounts');
            $table->integer('company_id')->references('id')->on('companies');
            $table->integer('city_id')->references('id')->on('cities');
            $table->integer('collection_id');
            $table->integer('puy_price');
            $table->integer('sale_price');
            $table->bigInteger('key');
            $table->tinyInteger('used')->default(0);
            $table->integer('created_by');
            $table->tinyInteger('disable')->default(0);
            $table->timestamps();
            $table->timestamp('puy_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
