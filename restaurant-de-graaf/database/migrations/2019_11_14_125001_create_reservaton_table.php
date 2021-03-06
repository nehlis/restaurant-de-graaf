<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservatonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->string('reservation_code')->unique();
            $table->unsignedBigInteger('UserID')->nullable();
            $table->dateTime('date');
            $table->unsignedInteger('duration')->comment("Geeft aan hoe lang deze reservering duurt in minuten");
            $table->text('comment')->nullable();
            $table->double('payed_price')->nullable();
            $table->unsignedBigInteger('guest_amount')->nullable(false);
            $table->timestamps();

            $table->foreign('UserID')->references('id')->on('users');
        });

//        Schema::table('reservation', function($table) {
//            $table->foreign('UserID')->references('id')->on('users');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservaton');
    }
}
