<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_user_answer');
    }
}
