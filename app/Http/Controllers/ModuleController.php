<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        $modulesQuery = Module::whereHas('lessons')->withCount('lessons')->where('id', '>', 0);

        if ($request->has('search')) {
            $modulesQuery = $modulesQuery->where('title', 'LIKE', "%{$request->get('search')}%");
        }

        if ($request->has('categories')) {
            $categories = $request->get('categories');

             $modulesQuery = $modulesQuery->whereIn('category_id', explode(',', $categories));
        }

        if ($request->has('sortBy')) {
            $sortBy = $request->get('sortBy');
            switch ($sortBy) {

                case 'nameAsc':
                    $modulesQuery = $modulesQuery->orderBy('title', 'ASC');
                    break;
                case 'nameDesc':
                    $modulesQuery = $modulesQuery->orderBy('title', 'DESC');

                    break;
                case 'oldest':
                    $modulesQuery = $modulesQuery->orderBy('created_at', 'ASC');

                    break;
                case 'newest':
                    $modulesQuery = $modulesQuery->orderBy('created_at', 'DESC');

                    break;
            }


         }


        $modules = collect($modulesQuery->paginate(12));
         if ($request->ajax()) {
            return $modules;
        }

        return view('modules.modules', compact('modules'));
    }

    public function show(Request $request, $id)
    {
        $module = Module
            ::with('lessons')
            ->where('id', $id)
            ->first();

        return view('modules.module', compact('module'));
    }
}
