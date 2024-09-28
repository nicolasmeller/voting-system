<?php

namespace App\Models;

use App\Models\User ;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use SoftDeletes;

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
