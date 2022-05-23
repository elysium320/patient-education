<?php

namespace App\Http\Controllers;

use App\Models\TakenQuiz;
use Illuminate\Http\Request;

class AnalyticController extends Controller
{
    public function index(Request $request)
    {

        $takenQuizzes = TakenQuiz::with('quiz')->with(['takenQuestions' => function ($query) {

            $query->with(['answers.givenAnswer' => function ($query) {
                //                $query->select(['id', 'content']);
            }]);

            $query->with(['question' => function ($query) {
            }]);
            $query->with(['correctAnswer' => function ($query) {
            }]);
            $query->with(['chosenAnswer.givenAnswer' => function ($query) {
            }]);

        }])->orderBy('created_at', 'desc')->paginate(50);
//        echo "test";
        echo $takenQuizzes;



        return view('admin.analytic', compact('takenQuizzes'));
    }
}
