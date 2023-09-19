<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {   $credentials = $request->all();
        $validator = Validator::make($credentials, [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails())
        {
            return response($validator->messages(), 400);
        }


        if (Auth::attempt($credentials)) {
            $user = $request->user();
            dd($user);
            $token = $user->createToken('bearer');
            return response()->json([
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'token' => $token->plainTextToken])
        ->header('Content-Type', 'application/json');
        }

        return response('Invalid Credentials', 401);
    }



}
