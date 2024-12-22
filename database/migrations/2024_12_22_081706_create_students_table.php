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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('address');
            $table->string('profile');
            $table->string('phone');
            $table->date('dob')->nullable();
            $table->string('email')->unique();
            $table->boolean('is_appeared_previously')->default(false);
            $table->string('receipt_image');
            $table->unsignedBigInteger('consultancy_id');
            $table->foreign('consultancy_id')->references('id')->on('consultancies')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
