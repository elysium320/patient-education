<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakenAnswers extends Model
{
    use HasFactory;

    protected $fillable = ['taken_quiz_question_id', 'answer', 'correct', 'updated_at', 'created_at'];




    public function givenAnswer() {
        return $this->belongsTo(Answer::class, 'answer');
    }

}
