<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request) {
        $searchTerm = $request->get('search', '');
        if ($searchTerm) {
            return Category::whereName($searchTerm)->get();

        } else {
            return Category::all();
        }
    }
}
