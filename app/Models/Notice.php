<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notice extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'image', 'description', 'author_name', 'slug'];
    // use slug instead of id
    public function getRouteKeyName()
    {
        return 'slug';
    }
    // Automatically boot the model
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($notice) {
            if (empty($notice->slug)) {
                $notice->slug = self::generateUniqueSlug();
            }
        });
    }

    // Generate unique slug
    public static function generateUniqueSlug()
    {
        do {
            $slug = Str::random(8); // Generate random 8-character string
        } while (self::where('slug', $slug)->exists());

        return $slug;
    }
}
