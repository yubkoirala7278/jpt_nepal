<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Consultancy extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'slug', 'phone', 'address', 'logo', 'test_center_id', 'status', 'disabled_reason', 'owner_name', 'mobile_number'];
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

    // define relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function test_center()
    {
        return $this->belongsTo(User::class, 'test_center_id');
    }

    public function students()
    {
        return $this->hasMany(Students::class, 'user_id', 'user_id');
    }
}
