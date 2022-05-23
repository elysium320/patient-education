<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required_with:password|same:password',
            'user_id' => 'required'

            ]);

            $user = User::findOrFail($request->get('user_id'));

            return $user->update(['password' => Hash::make($data['password'])]);

    }
}
