<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;

class SingleLessonController extends Controller
{
    public function index(Request $request, int $moduleId, int $id)
    {
        $lesson = Lesson::with('images')
            ->with('videos')
            ->where('id', $id)
            ->first();

        $module = Module::with('lessons')->findOrFail($moduleId);

        return view('lessons.lesson', compact('lesson', 'module'));
    }

    public function singleLesson(Request $request, int $id)
    {
        $lesson = Lesson::with('images')
            ->with('videos')
            ->where('id', $id)
            ->first();

        $modules = $lesson->module;

        $module = false;
        if (count($modules)) {

            $module = $modules[0];
        }


        return view('lessons.lesson', compact('lesson', 'module'));
    }


}
