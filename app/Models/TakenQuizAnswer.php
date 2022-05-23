<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakenQuizAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'taken_quiz_id',
        'question_id',
        'content',
        'chosen_answer_id',
        'correct_answer_id',
        'correct',
        'created_at',
        'created_at',
    ];

    protected $appends = ['correct_or_wrong', 'actual_question', 'correct_answers', 'chosen_answers'];

    public function getCorrectOrWrongAttribute()
    {
        if ($this->correct_answer_id === $this->chosen_answer_id) {
            return 'correct';
        } else {
            return 'wrong';
        }
    }
    public function getActualQuestionAttribute()
    {
            if ($this->question) {
                return $this->question->question;
            }
    }

    public function getCorrectAnswersAttribute()
    {
        if ($this->question) {
             if ($this->question->correct_answer != null) {
                return $this->question->correct_answer ? 'true' : 'false';
            }

            return $this->question->correctAnswers;
        }
    }

    public function getChosenAnswersAttribute()
    {
        if ($this->question) {


            return $this->chosenAnswer;
        }
    }


    public function correctAnswer()
    {
        return $this->hasMany(TakenAnswers::class, 'taken_quiz_question_id', 'id')->where('correct', 1);
    }

    public function chosenAnswer()
    {
        return $this->hasMany(TakenAnswers::class, 'taken_quiz_question_id', 'id');
    }

    public function question()
    {
        return $this->hasOne(Question::class, 'id', 'question_id');
    }

    public function answers()
    {
        return $this->hasMany(TakenAnswers::class, 'taken_quiz_question_id', 'id');

    }


}
