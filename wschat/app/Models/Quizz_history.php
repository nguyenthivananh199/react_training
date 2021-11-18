<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quizz_history extends Model
{
    use HasFactory;
    protected $table = 'quizz_histories';
    protected $fillable = [
        'test_id',
        'user_id',
        'score'
    ];
}
