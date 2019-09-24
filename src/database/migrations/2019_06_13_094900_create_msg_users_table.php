<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsgUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msg_users', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('username')->nullable();
            $table->integer('discount_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('viber_id')->nullable();
            $table->string('telegram_id')->nullable();
            $table->string('fbmessenger_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('msg_users');
    }
}
