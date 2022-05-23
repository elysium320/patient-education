<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\ModuleLesson;
use Illuminate\Http\Request;

class ApiModuleController extends Controller
{

    /*
        Create new module
    */
    public function create_module(Request $request)
    {

        //  Validate Parameters
        $validator = \Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',

        ]);

        if ($validator->fails()) {

            return response()->json(
                [
                    "status" => "error",
                    "message" => $validator->errors()
                ],
                401

            );
        }
        $module = new Module();
        if ($module->where("title", $request->title)->first()) {
            return response()->json(
                [
                    "status" => "401",
                    "message" => "Module name already exist"
                ],
                401
            );
        }

        $result = $module->create_module($request);

        if ($result) {
            return response()->json(
                [
                    "status" => "200",
                    "message" => "Module created successfully"
                ]
            );
        } else {
            return response()->json(
                [
                    "status" => "400",
                    "message" => "Error in creating module"
                ],
                400
            );
        }
    }

    /** Update Module*/
    public function update_module(Request $request)
    {

        //  Validate Parameters
        $validator = \Validator::make($request->all(), [
            'id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'lesson_ids' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json(
                [
                    "status" => "error",
                    "message" => $validator->errors()
                ],
                403
            );
        }
        $module = new Module();

        if (!$module->find($request->id)) {
            return response()->json(
                [
                    "status" => "204",
                    "message" => "Module not found"
                ],
                401
            );
        }


        $result = $module->update_module($request);

        if ($result) {
            return response()->json(
                [
                    "status" => "200",
                    "message" => "Module created updated"
                ]
            );
        } else {
            return response()->json(
                [
                    "status" => "404",
                    "message" => "Error in updating module"
                ],
                403
            );
        }
    }

    public function module_with_lesson(Request $request)
    {

        $query = Module::withCount('lessons');

        if ($request->has('search')) {
            $query = $query->where('title', 'LIKE', "%{$request->get('search')}%");
        }

        return $query->get();
    }

    public function delete(Request $request, int $id)
    {

        $module = Module::findOrFail($id);

        ModuleLesson::where('module_id', $id)->delete();
        $module->delete();

        return response()->json('success');
    }
}
