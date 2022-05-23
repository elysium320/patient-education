<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'description',
        'question',
        'correct_answer'
    ];


    public function answers() {
        return $this->belongsToMany(Answer::class, 'question_answers')
            ->select(['answers.*', 'question_answers.*', 'correct_answer_id', 'answer_id', 'content']);
    }

    public function correctAnswers() {
        return $this->belongsToMany(Answer::class, 'question_answers', 'question_id')
            ->whereNotNull('correct_answer_id');
    }

}
