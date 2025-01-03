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
        Schema::create('consultancies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('test_center_id');
            $table->foreign('test_center_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('slug')->unique();
            $table->string('phone');
            $table->string('address');
            $table->string('logo');
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
        Schema::dropIfExists('consultancies');
    }
};
