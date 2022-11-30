<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->text('icon');
            $table->text('name');
            $table->double('lat');
            $table->double('long');
            $table->text('country');
            $table->text('city');
            $table->text('street');
            $table->integer('build_number');
            $table->integer('house_number');
            $table->integer('floor_number');
            $table->text('note');
            $table->integer('code_id');
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
        Schema::dropIfExists('addresses');
    }
};
