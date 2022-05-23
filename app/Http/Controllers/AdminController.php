<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.admin');
    }

    public function profile(Request $request)
    {
        return view('admin.user-profile');
    }

    public function modules(Request $request)
    {
        return view('admin.modules');
    }

    public function lessons(Request $request)
    {
        $lessons = Lesson::all();

        return view('admin.lessons', compact('lessons'));
    }

    public function quizzes(Request $request)
    {
        return view('admin.quizzes');
    }

    public function createModule(Request $request)
    {
        return view('admin.create_module');
    }

    public function editModule(Request $request, int $id)
    {
        $module = Module::with('lessons')->findOrFail($id);
        return view('admin.edit_module', compact('module'));
    }

    public function createLesson(Request $request)
    {
        return view('admin.create_lesson');
    }

    public function showUpdateForm(Request $request, int $id)
    {
        $lesson = Lesson::with(['quizzes' => function ($query) {
            $query->with(['questions' => function ($query) {
                $query->with('answers');
                $query->with('correctAnswers');
            }]);
        }])
            ->findOrFail($id);

        return view('admin.update_lesson', compact('lesson'));

    }

    public function createAccount(Request $request)
    {
        return view('admin.create_account');
    }

    public function getModuleLessons(Request $request, int $id)
    {
        $module = Module::findOrFail($id);

        $lessons = $module->lessons;

        return view('admin.module_lessons', compact('module', 'lessons'));
    }
}