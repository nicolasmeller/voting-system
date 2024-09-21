<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function surveys()
    {
        return $this->belongsToMany(Survey::class, 'question_survey');
    }

    public function userAnswers()
    {
        return $this->belongsToMany(UserAnswer::class, 'question_user_answer');
    }
}
