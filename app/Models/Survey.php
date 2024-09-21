<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{

    protected $fillable = [
        'name',
        'description',
        'user_id'
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_survey');
    }
}
