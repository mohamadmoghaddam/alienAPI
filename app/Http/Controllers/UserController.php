<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all()->toJson();
        return response($users)
        ->header('Content-Type', 'application/json');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'username' => 'required|unique:users',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails())
        {
            return response($validator->messages(), 400);
        }
        User::create($data);
        $userJson = json_encode($data);
        return response($userJson)
        ->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if(empty($user)){
            return response('invalid user id', 400);
        }
        $userJson = $user -> toJson();
        return response($userJson)
        ->header('Content-Type', 'application/json');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if(empty($user)){
            return response('invalid user id', 400);
        }
        $data = $request->all();
        $validator = Validator::make($data, [
            'username' => [
                'required',
                Rule::unique('users')->ignore($id, 'id')],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id, 'id')],
            'password' => 'required|min:8'
        ]);

        if ($validator->fails())
        {
            return response($validator->messages(), 400);
        }
        $user->update($data);
        $userJson = json_encode($data);
        return response($userJson)
        ->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if(empty($user)){
            return response('invalid user id', 400);
        }
        $userJson = $user->toJson();
        $user->delete();
        return response($userJson)
        ->header('Content-Type', 'application/json');
    }
}
