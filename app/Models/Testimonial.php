<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Testimonial extends Model
{
    use HasFactory;
    protected $fillable=['slug','name','description','status'];

   // Automatically boot the model
   protected static function boot()
   {
       parent::boot();

       static::creating(function ($testimonial) {
           if (empty($testimonial->slug)) {
               $testimonial->slug = self::generateUniqueSlug();
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
