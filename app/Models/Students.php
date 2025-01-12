<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address','amount', 'profile', 'phone', 'slug', 'dob', 'email', 'is_appeared_previously', 'receipt_image', 'user_id','exam_date_id','status','is_viewed_by_admin','is_viewed_by_test_center_manager','citizenship','gender','nationality','exam_number','examinee_category','exam_category','test_venue','venue_code','venue_name','venue_address'];
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

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function exam_date(){
        return $this->belongsTo(ExamDate::class);
    }
    public function admit_cards() {
        return $this->hasOne(AdmitCard::class,'student_id');
    }

    public function results() {
        return $this->hasOne(Result::class,'student_id');
    }
}
