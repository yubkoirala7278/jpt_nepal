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
            $table->decimal('amount', 8, 2)->nullable();
            $table->string('profile');
            $table->string('phone');
            $table->date('dob')->nullable();
            $table->string('email')->unique();
            $table->boolean('is_appeared_previously')->default(false);
            $table->string('receipt_image')->nullable();
            $table->string('citizenship');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('exam_date_id');
            $table->foreign('exam_date_id')->references('id')->on('exam_dates')->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('status')->default(false);
            $table->boolean('is_viewed_by_test_center_manager')->default(false);
            $table->boolean('is_viewed_by_admin')->default(false);
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('nationality');
            $table->string('exam_number')->nullable();
            $table->string('examinee_category');
            $table->string('exam_category');
            $table->string('test_venue');
            $table->string('venue_code');
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
