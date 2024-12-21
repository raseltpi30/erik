<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('commercials', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('street')->nullable();
            $table->string('unit')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->integer('square_footage')->nullable();
            $table->integer('number_floors')->nullable();
            $table->string('types_areas')->nullable();
            $table->text('specific_tasks')->nullable();
            $table->string('cleaning_frequency')->nullable();
            $table->text('cleaning_schedule')->nullable();
            $table->string('access_security')->nullable();
            $table->text('additional_services')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('commercials');
    }
};
