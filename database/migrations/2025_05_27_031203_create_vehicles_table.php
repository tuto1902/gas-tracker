<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('make');
            $table->string('model');
            $table->string('nickname')->nullable();
            $table->integer('year');
            $table->integer('initial_odometer');
            $table->string('distance_units');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }
};
