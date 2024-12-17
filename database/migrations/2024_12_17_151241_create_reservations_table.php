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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->integer('table_number');
            $table->integer('number_guests');
            $table->date('date');
            $table->string('time');
            $table->text('message')->nullable();
            $table->timestamps();

            // Add a unique constraint for the combination of table_number, date, and time
            $table->unique(['table_number', 'date', 'time']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
