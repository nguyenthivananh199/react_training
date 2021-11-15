<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course_member extends Model
{
    use HasFactory;
    protected $table = 'course_member';
    protected $fillable = [
        'course_id',
        'user_id'
    ];
}
