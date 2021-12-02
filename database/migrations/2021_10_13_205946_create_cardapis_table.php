<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardapisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cardapis', function (Blueprint $table) {
            $table->id();
            $table->string('type_card')->nullable();
            $table->double('buy_card')->nullable();
            $table->double('sale_card')->nullable();
            $table->boolean('active')->default(true);
            $table->string("image")->nullable();
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
        Schema::dropIfExists('cardapis');
    }
}