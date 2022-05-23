<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Lesson;
use App\Models\LessonQuiz;
use App\Models\Module;
use App\Models\ModuleLesson;
use App\Models\Quiz;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getLessons() {
        return Lesson::all();
    }

    public function storeLesson(Request $request) {
       $attributes = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'instructions' => 'string',
            'additional_info' => 'string',
            'category_id' => 'numeric',
        ]);

        return Lesson::create($attributes);
    }
    public function deleteLesson(Request $request, int $id) {

        $lesson = Lesson::findOrFail($id);
        LessonQuiz::where('lesson_id', $id)->delete();
        ModuleLesson::where('lesson_id', $id)->delete();
        Quiz::where('lesson_id', $id)->delete();
        Image::where('entity_type', Lesson::class)->where('entity_id', $id);

        $lesson->delete();



    }
     public function updateLesson(Request $request, int $id)
     {
         $lesson = Lesson::findOrFail($id);

         $lesson->update($request->all());

         return $lesson->fresh();
     }

    public function getCategories(Request $request, int $id)
    {
        return Category::all();

    }

    public function showLesson(Request $request, int $id) {
        return Lesson::with('videos')
            ->with('images')
//            ->with('quizzes.questions.answers')
            ->with(['quizzes' => function($query){
                $query->with([
                    'questions' => function($query) {
                        $query->with([
                            'answers',

                        ]);
                    }
                ]);

            }])
            ->where('id', $id)
            ->first();
    }

}
