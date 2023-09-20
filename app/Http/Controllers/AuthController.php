<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->all();
        $validator = Validator::make($credentials, [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails())
        {
            return response($validator->messages(), 400);
        }

        $user = User::where('username', '=', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response('Invalid Credentials', 401);
        }

        $token = $user->createToken('bearer');
            return response()->json([
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'token' => $token->plainTextToken])
        ->header('Content-Type', 'application/json');
    }

    public function logout(Request $request)
    {
        $user = User::find($request->id)->first();
        $user->tokens()->delete();
        return response()->json([
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email']
            ])
        ->header('Content-Type', 'application/json');
    }

    public function register(Request $request)
        {
            $data = $request->all();
            $validator = Validator::make($data, [
                'username' => 'required|unique:users',
                'email' => 'required|unique:users|email',
                'password' => 'required|confirmed|min:8'
            ]);

            if ($validator->fails())
            {
                return response($validator->messages(), 400);
            }
            User::create($data);
            return response()->json($data)
            ->header('Content-Type', 'application/json');
        }

}
