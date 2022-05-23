<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('all')) {
            $lessonsQuery = Lesson::with('images')->with('videos');
        } else {
            $lessonsQuery = Lesson::whereHas('module')->with('images')->with('videos');

            if ($request->has('categories')) {
                $categories = $request->get('categories');

                $lessonsQuery = $lessonsQuery->whereIn('category_id', explode(',', $categories));
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

        }

        if ($request->has('search')) {
            $lessonsQuery = $lessonsQuery->where('title', 'LIKE', "%{$request->get('search')}%");
        }
        if ($request->has('all')) {
            $lessons = $lessonsQuery->get();

        } else {
            $lessons = collect($lessonsQuery->paginate(12));

        }


        if ($request->ajax()) {
            return collect($lessons);
        }

        return view('lessons.lessons', compact('lessons'));
    }

    public function setLocale(Request $request, $locale)
    {
        session()->put('locale', $locale);

        return redirect('/');

    }
}
