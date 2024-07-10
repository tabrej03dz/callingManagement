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
        Schema::create('numbers', function (Blueprint $table) {
            $table->id();
            $table->string('business_name')->nullable();
            $table->string('phone_number')->unique();
            $table->string('city')->nullable();
            $table->enum('assigned', ['0', '1'])->default('0');
            $table->enum('status', ['interested', 'not interested', 'wrong number', 'converted', null])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('numbers');
    }
};
