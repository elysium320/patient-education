<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class QuizzesController extends Controller
{
    public function index(Request $request)
    {
        return view('quizzes.quizzes');
    }
}
