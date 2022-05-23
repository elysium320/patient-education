<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ApiAdminController extends Controller
{
    public function create_acount(Request $request)
    {
        $user = new User();

        if (!$request->email || !$request->password || !$request->name) {
            return response([
                'status' => 401,
                "Message" => "Missing parameters"
            ], 401);
        }

        // Verifiy Token
        // check  duplicate Email
        if (!$user->where('email', $request->email)->first()) {

            // Create Record
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'api_token' => Str::random(60),
            ]);

            return response([
                'status' => 204,
                "Message" => "User created successfully"
            ]);
        } else {
            return response([
                'status' => 401,
                "Message" => "Email already exits"
            ], 401);
        }
    }



}
