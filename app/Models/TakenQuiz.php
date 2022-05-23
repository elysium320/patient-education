<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakenQuiz extends Model
{
    use HasFactory;
    protected $fillable = [
        'ip_address',
        'country',
        'quiz_id',
        'score',
        'correct_answers',
        'wrong_answers',
        'started_at',
        'finished_at',
        'created_at',
    ];

    protected $appends = ['taken_questions_count', 'total_correct_count'];

    public function getTakenQuestionsCountAttribute()
    {
        return $this->takenQuestions()->count();
    }

    public function getTotalCorrectCountAttribute()
    {
        $totalCorrect = 0;
        foreach ($this->takenQuestions as $question) {
            $answers = $question->answers()->selectRaw('sum(correct) as sum')->where('correct', 1)->groupBy('taken_quiz_question_id')->first();


            if (optional($question->question)->type === QuestionType::TYPES['MULTIPLE']) {
                $originalCorrectAnswersCount = optional($question->question)->correctAnswers()->count();

                if ($answers && ($originalCorrectAnswersCount === (int) $answers->sum)) {
                    $totalCorrect++;
                }
            } else if ($answers) {
                $totalCorrect++;
            }
        }

        return $totalCorrect;
    }




    public function takenQuestions()
    {
        return $this->hasMany(TakenQuizAnswer::class, 'taken_quiz_id');
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class, 'id', 'quiz_id');
    }
}
