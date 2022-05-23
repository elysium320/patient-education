<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionType;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\TakenAnswers;
use App\Models\TakenQuiz;
use App\Models\TakenQuizAnswer;
use Carbon\Carbon;
use Database\Seeders\QuestionTypeSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Location;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $lessonsQuery = Quiz::whereHas('lesson', function ($query) use ($request) {
             if ($request->has('categories')) {
                $categories = $request->get('categories');

                 $query->whereIn('category_id', explode(',', $categories));
            }

        })->with([
            'lesson'
        ]);

        if ($request->has('search')) {
            $lessonsQuery =   $lessonsQuery->where('title', 'LIKE', "%{$request->get('search')}%");
        }



        if ($request->has('sortBy')) {
            $sortBy = $request->get('sortBy');

            switch ($sortBy) {

                case 'nameAsc':
                    $lessonsQuery = $lessonsQuery->orderBy('title', 'ASC');
                    break;
                case 'nameDesc':
                    $lessonsQuery = $lessonsQuery->orderBy('title', 'DESC');

                    break;
                case 'oldest':
                    $lessonsQuery = $lessonsQuery->orderBy('created_at', 'ASC');

                    break;
                case 'newest':
                    $lessonsQuery = $lessonsQuery->orderBy('created_at', 'DESC');

                    break;
            }


        }

        $quizzes = collect($lessonsQuery->paginate());

        if ($request->ajax()) {
            return collect($quizzes);
        }

        return view('quizzes.quizzes', compact('quizzes'));
    }

    public function show(Request $request, int $id)
    {
        $quiz = Quiz::with('questions.answers')
            ->whereId($id)
            ->first();

        if (!$quiz) {
            return redirect('/lessons');
        }


        return view('quizzes.quiz', compact('quiz'));

    }


    public function store(Request $request)
    {
        $validatedAttributes = $request->validate([
            'lesson_id' => 'required|numeric',
            "questions" => "required|array|min:1",
            "questions.*.type" => "required|numeric",
            "questions.*.correct" => "required",
        ]);
        $lesson = Lesson::findOrFail($validatedAttributes['lesson_id']);

        if ($request->has('quiz_id')) {
            $quiz = Quiz::findOrFail($request->get('quiz_id'));
            $quiz->questions()->delete();
        } else {
            $quiz = Quiz::create(['title' => $lesson->title, 'lesson_id' => $lesson->id]);
            $lesson->quizzes()->attach([$quiz->id]);

        }

        $questions = $request->get('questions');

        $questionIds = [];
        foreach ($questions as $question) {
            $payload = [
                'type' => $question['type'],
                'description' => $question['description'],
                'question' => $question['question'],
            ];

            if ($question['type'] === QuestionType::TYPES['BOOLEAN']) {
                $payload['correct_answer'] = $question['correct'];
            }
            $newQuestion = Question::create($payload);

            $questionIds[] = $newQuestion->id;
            $answerIds = [];
            if ($question['type'] != QuestionType::TYPES['BOOLEAN'])
                foreach ($question['answers'] as $key => $answer) {
                    $newAnswer = Answer::create([
                        'content' => $answer['answer']
                    ]);

                    $answerIds[] = $newAnswer->id;

                }

            foreach ($answerIds as $key => $newAnswer) {
                $questionAnswer = QuestionAnswer::create([
                    'question_id' => $newQuestion->id,
                    'answer_id' => $newAnswer,
                ]);

                if ($question['type'] === QuestionType::TYPES['MULTIPLE'] &&
                    count($question['correct_multiple'])) {
                    $correctAnswers = $question['correct_multiple'];
                    sort($correctAnswers);
                    if (isset($correctAnswers[$key])) {
                        $questionAnswer->update(['correct_answer_id' => $newAnswer]);
                    }
                } else if ($question['type'] === QuestionType::TYPES['SINGLE'] && isset($question['correct'])) {
                    if ($key === $question['correct']) {
                        $questionAnswer->update(['correct_answer_id' => $newAnswer]);

                    }

                } else if ($question['type'] === QuestionType::TYPES['BOOLEAN'] && isset($question['BOOLEAN'])) {

                }
            }

        }
        $quiz->questions()->attach($questionIds);

        return response()->json('success');
    }
    public function update(Request $request)
    {
        $validatedAttributes = $request->validate([
            'lesson_id' => 'required|numeric',
            "questions" => "required|array|min:1",
            "questions.*.type" => "required|numeric",
            "questions.*.correct" => "required",
        ]);
        $lesson = Lesson::findOrFail($validatedAttributes['lesson_id']);

        if (!$request->has('quiz_id')) {
            abort(404);

        }

        $quiz = Quiz::findOrFail($request->get('quiz_id'));


        $questions = $request->get('questions');

        $questionIds = [];
        foreach ($questions as $question) {
            $payload = [
                'type' => $question['type'],
                'description' => $question['description'],
                'question' => $question['question'],
            ];

            if ($question['type'] === QuestionType::TYPES['BOOLEAN']) {
                $payload['correct_answer'] = $question['correct'];
            }
            if (isset($question['id'])) {
                $newQuestion = Question::find($question['id']);
                if ($newQuestion) {
                    $newQuestion->update($payload);
                }

            }else {
                $newQuestion = Question::create($payload);

            }
//
            $questionIds[] = $newQuestion->id;
            $answerIds = [];
            if ($question['type'] != QuestionType::TYPES['BOOLEAN'])
                foreach ($question['answers'] as $key => $answer) {
                    if (isset($answer['answer_id'])) {
                        $newAnswer = Answer::find($answer['answer_id']);
                        if ($newAnswer) {
                            $newAnswer->update([
                                'content' => $answer['answer']
                            ]);
                        }

                    } else {
                        $newAnswer = Answer::create([
                            'content' => $answer['answer']
                        ]);
                    }


                    $answerIds[] = $newAnswer->id;

                }

            foreach ($answerIds as $key => $newAnswer) {
               $questionAnswer =  QuestionAnswer::where('question_id', $newQuestion->id)->where('answer_id', $newAnswer)->first();
               if ($questionAnswer) {
                   $questionAnswer->update([
                       'question_id' => $newQuestion->id,
                       'answer_id' => $newAnswer,
                   ]);
               } else {
                   $questionAnswer = QuestionAnswer::create([
                       'question_id' => $newQuestion->id,
                       'answer_id' => $newAnswer,
                   ]);
               }


                if ($question['type'] === QuestionType::TYPES['MULTIPLE'] &&
                    count($question['correct_multiple'])) {
                    $correctAnswers = $question['correct_multiple'];
                    sort($correctAnswers);
                    if (isset($correctAnswers[$key])) {
                        $questionAnswer->update(['correct_answer_id' => $newAnswer]);
                    }
                } else if ($question['type'] === QuestionType::TYPES['SINGLE'] && isset($question['correct'])) {
                    if ($key === $question['correct']) {
                        $questionAnswer->update(['correct_answer_id' => $newAnswer]);

                    }

                } else if ($question['type'] === QuestionType::TYPES['BOOLEAN'] && isset($question['BOOLEAN'])) {

                }
            }

        }
        $quiz->questions()->sync($questionIds);

        return response()->json('success');
    }

    public function getQuestionTypes(Request $request)
    {
        return QuestionType::all();
    }

    public function storeQuizResults(Request $request)
    {
        $questions = $request->get('questions');
        $quizId = $request->get('quiz_id');
        if ($position = \Stevebauman\Location\Facades\Location::get($request->ip())) {
            // Successfully retrieved position.
            $position = $position->countryName;
        } else {
            $position = 'NO COUNTRY';
        }
        $takenQuiz = TakenQuiz::create([
            'quiz_id' => $quizId,
            'ip_address' => $request->ip(),
            'country' => $position,
            'finished_at' => Carbon::now(),

        ]);

        foreach ($questions as $question) {
            $questionObj = Question::find($question['id']);
            if ($questionObj) {
                $takenQuizQuestion = TakenQuizAnswer::create([
                    'taken_quiz_id' => $takenQuiz->id,
                    'question_id' => $questionObj->id,
                    'chosen_answer_id' => 0,
                    'correct_answer_id' => 0,
                ]);


                if (isset($question['correct_answer']) && $question['correct_answer'] !== null) {
                    TakenAnswers::create([
                        'question_id' => $questionObj->id,
                        'taken_quiz_question_id' => $takenQuizQuestion->id,
                        'answer' => 1,
                        'correct' => (int)$question['correct_answer'],
                    ]);
                    $takenQuiz->total_answers = $takenQuiz->total_answers + 1;

                    if ((int)$question['correct_answer']) {
                        $takenQuiz->correct_answers = $takenQuiz->correct_answers + 1;
                    } else {
                        $takenQuiz->wrong_answers = $takenQuiz->wrong_answers + 1;

                    }
                    $takenQuiz->save();

                } else if (isset($question['chosen_answers'])) {
                    $originalQuestionAnswers = $questionObj->correctAnswers()->pluck('question_answers.correct_answer_id')->toArray();

                    if (is_array($question['chosen_answers'])) {
                        foreach ($question['chosen_answers'] as $chosenAnswer) {
                            TakenAnswers::create([
                                'question_id' => $questionObj->id,
                                'taken_quiz_question_id' => $takenQuizQuestion->id,
                                'answer' => $chosenAnswer,
                                'correct' => in_array($chosenAnswer, $originalQuestionAnswers),
                            ]);
                            $takenQuiz->total_answers = $takenQuiz->total_answers + 1;

                            if (in_array($question['chosen_answers'], $originalQuestionAnswers)) {
                                $takenQuiz->correct_answers = $takenQuiz->correct_answers + 1;
                            } else {
                                $takenQuiz->wrong_answers = $takenQuiz->wrong_answers + 1;

                            }
                            $takenQuiz->save();

                        }
                    } else {
                        TakenAnswers::create([
                            'question_id' => $questionObj->id,
                            'taken_quiz_question_id' => $takenQuizQuestion->id,
                            'answer' => $question['chosen_answers'],
                            'correct' => in_array($question['chosen_answers'], $originalQuestionAnswers),

                        ]);
                        $takenQuiz->total_answers = $takenQuiz->total_answers + 1;

                        if (in_array($question['chosen_answers'], $originalQuestionAnswers)) {
                            $takenQuiz->correct_answers = $takenQuiz->correct_answers + 1;

                        } else {
                            $takenQuiz->wrong_answers = $takenQuiz->wrong_answers + 1;

                        }
                        $takenQuiz->save();

                    }
                }
            }


        }


        return $takenQuiz;


    }


    public function deleteQuestion(Request  $request, int $id)
    {
        $question = Question::findOrFail($id);
        QuizQuestion::where('question_id', $id)->delete();
        QuestionAnswer::where('question_id', $id)->delete();
        $question->answers()->delete();
        $question->delete();


        return response()->json('success');
    }
}
