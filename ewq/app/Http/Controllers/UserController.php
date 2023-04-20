<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserRequest;
// use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function signup(UserRequest $request)
    {
        $user = User::create([
            'password' => Hash::make($request->password)
        ]+$request->validated());

        return response() -> json([
            'data'=> [
                'status'=> 'true',
                'id'=> $user->id
            ]
        ])->setStatusCode(200, 'Succeful registration')->header('Content-Type','application/json');
    }

    public function auth(AuthRequest $request)
    {
        if(Auth::attempt($request->validated()))
        {
                Auth::user()->tokens()->delete();
                return response()-> json([
                    'data'=> [
                        'status'=> 'true',
                        'token'=> Auth::user()->createToken('Api')->plainTextToken
                    ]
                ]) ->setStatusCode(200, 'Succeful authorization')->header('Content-Type','application/json');
        }
        else
        {
            return response() -> json([
                'data'=> [
                    'status'=> 'false',
                    'message'=>'Invalid authorization data' ]
                ])->setStatusCode(401, 'Invalid authorization data')->header('Content-Type','application/json');
        }
    }
    // public function show($id){
    //     $user = user::where('id', $id)->first();
    //     if($user===null){
    //         return response()-> json([
    //             'data' => [
    //                 'message' => 'user not found'
    //             ]
    //         ])->setStatusCode(401, 'user not found');
    //     }
    //     else{
    //         return response()-> json([
    //             'data'=>[
    //                 new UserResource($user)
    //             ]]
    //             )->setStatusCode(220, 'Wiew user');
    //     }
    // }
}
