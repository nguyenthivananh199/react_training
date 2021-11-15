<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'test_id',
        'question',
        'type',
        'ans1',
        'ans2',
        'ans3',
        'ans4',
        'blankAns',
        'correctAns',
        'explaination',

    ];
    public function test()
    {
      return $this->belongsTo(Test::class);
    }
}
