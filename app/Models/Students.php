<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address', 'profile', 'phone', 'slug', 'dob', 'email', 'is_appeared_previously', 'receipt_image', 'consultancy_id'];
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
}
