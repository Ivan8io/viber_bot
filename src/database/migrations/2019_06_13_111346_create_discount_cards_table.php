<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('msguser_id')->nullable();
            $table->string('phone')->nullable();
            $table->integer('number');
            $table->string('ean')->unique();
            $table->decimal('bonuses')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_cards');
    }
}
