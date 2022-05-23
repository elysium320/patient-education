<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\QuestionType;
use App\Models\Quiz;
use App\Models\TakenQuiz;
use Illuminate\Http\Request;
use function Symfony\Component\String\u;

class ReportCardController extends Controller
{
    public function index(Request $request, int $quizId)
    {
       $quiz = TakenQuiz::findOrFail($quizId);
        $lesson = Lesson::findOrFail(optional($quiz->quiz)->lesson_id);
         $modules = $lesson->module()->with('lessons')->get();


        $module = false;
        if (count($modules)) {

            $module = $modules[0];
        }


        return view('quizzes.reportCard', compact('quizId', 'module'));
    }

    public function getResults(Request $request, int $quizId)
    {

        $takenQuestions = TakenQuiz::with(['takenQuestions' => function ($query) {
            $query->with(['answers.givenAnswer' => function ($query) {
//                $query->select(['id', 'content']);
            }]);

            $query->with(['question' => function ($query) {
             }]);
            $query->with(['correctAnswer' => function ($query) {
             }]);
            $query->with(['chosenAnswer.givenAnswer' => function ($query) {
            }]);


        },
            'quiz'
        ])->whereId($quizId)->first();

        $totalQuestions = $takenQuestions->takenQuestions()->count();

        $totalCorrect = 0;

        foreach ($takenQuestions->takenQuestions as $question) {
            $answers = $question->answers()->selectRaw('sum(correct) as sum')->where('correct', 1)->groupBy('taken_quiz_question_id')->first();

            if (optional($question->question)->type === QuestionType::TYPES['MULTIPLE']) {
                $originalCorrectAnswersCount = optional($question->question)->correctAnswers()->count();
                if ($answers && ($originalCorrectAnswersCount === (int) $answers->sum)) {
                    $totalCorrect++;


                }

            } else if($answers) {
                     $totalCorrect++;

             }




        }



        return response()->json([
            'total_questions' => $totalQuestions,
            'total_correct' => $totalCorrect,
            'percentage' => (($totalCorrect / $totalQuestions) * 100),
            'quiz_questions' => $takenQuestions
        ]);
    }
}
