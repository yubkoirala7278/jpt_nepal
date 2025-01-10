<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TestCenter extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'slug', 'phone', 'address','status','disabled_reason','test_venue','venue_code'];
    // Automatically boot the model
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($consultancy) {
            if (empty($consultancy->slug)) {
                $consultancy->slug = self::generateUniqueSlug();
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

    // use slug instead of id
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Relationship back to the user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consultancies()
    {
        return $this->hasMany(Consultancy::class, 'test_center_id', 'user_id');
    }
}
