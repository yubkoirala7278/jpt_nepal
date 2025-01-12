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
        Schema::create('test_centers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('slug')->unique();
            $table->string('venue_address');
            $table->string('test_venue');
            $table->string('venue_code');
            $table->string('venue_name');
            $table->string('phone');
            $table->string('contact_person');
            $table->string('mobile_no');
            $table->enum('status', ['active', 'disabled'])->default('active');
            $table->text('disabled_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_centers');
    }
};
