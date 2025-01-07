<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Header extends Model
{
    use HasFactory;
    protected $fillable=['slug','title','description','image'];
     // Boot method to handle model events
     protected static function boot()
     {
         parent::boot();
 
         // Automatically generate a unique slug when creating a header
         static::creating(function ($header) {
             $header->slug = static::generateUniqueSlug();
         });
     }
 
     /**
      * Generate an 8-character unique slug
      *
      * @return string
      */
     private static function generateUniqueSlug()
     {
         do {
             $slug = Str::random(8); // Generate an 8-character random string
         } while (self::where('slug', $slug)->exists()); // Ensure it's unique
 
         return $slug;
     }
}
