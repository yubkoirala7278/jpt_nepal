<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamDate extends Model
{
    use HasFactory;
    protected $fillable = ['slug', 'exam_date', 'exam_start_time', 'exam_end_time'];
    // Boot method to hook into the model's lifecycle events
    protected static function boot()
    {
        parent::boot();

        // Generate slug when a new ExamDate is created
        static::creating(function ($examDate) {
            $examDate->slug = self::generateSlug();
        });
    }

    // Function to generate a unique 8-character slug
    public static function generateSlug()
    {
        do {
            $slug = strtoupper(bin2hex(random_bytes(4))); // Generates an 8-character string
        } while (self::where('slug', $slug)->exists()); // Ensure uniqueness
        return $slug;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $casts = [
        'exam_start_time' => 'datetime:H:i',  // Format as time only (hours and minutes)
        'exam_end_time' => 'datetime:H:i',    // Format as time only (hours and minutes)
    ];
}
