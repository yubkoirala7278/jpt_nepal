<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmitCard extends Model
{
    use HasFactory;
    protected $fillable=['admit_card','student_id'];
}
