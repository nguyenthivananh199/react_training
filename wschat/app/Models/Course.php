<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'courses';
    protected $fillable = [
        'courseName',
        'courseStatus',
        'courseActive',
        'courseDescription',
        'courseLevel',
        'courseSubject',
        'user_id'
    ];
    public function member_course()
    {   
        return $this->belongsToMany(User::class, 'course_member', 'course_id', 'user_id');
    }
    public function member_course_active()
    {
        return $this->member_course()->where("userActive","1");
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    public function lessons_active()
    {
        return $this->lessons()->where("lessonActive","1");
    }
}
