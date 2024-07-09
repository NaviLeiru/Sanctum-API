<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash; 

class AuthController extends Controller
{
public function register(Request $request){

    try{
            $validateUser = Validator::make($request->all(),[
                'name' => 'required|string|max:255|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8',
            ]);

            if($validateUser->fails()){
                return response() -> json([
                    'status' => 'Error',
                    'message' => 'Validation Error',
                    'token' => $validateUser -> errrors(),
                ],401);
            };

            $newUser = User::create([
                'name' => $request -> name,
                'email' => $request -> emal,
                'password' => Hash::make($request -> password),
            ]);

            return response()->json([
                'status' => 'Ok',
                'message' => 'User is created successfully',
                'token' => $newUser -> creatToken('API-TOKEN') -> plainTextToken,
            ],200);
        } catch (\Throwable $error){
            return response()->json([
                'status' => 'Error',
                'message' => $error -> getMessage(),
            ],500);
        }
  }

  public function login(Request $request)
  {
    try{
        $credentials = Validator::make($request -> only(['name','password']),[
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        if($credentials->fails()){
            return response() -> jason([
                'status' => 'Error',
                'message' => 'validator Error',
                'errors' => $credentials -> errors(),
            ],401);
        }

        if (Auth::attempt($credentials)){
            $request -> session() -> regenerate();
            $token = $request -> user() ->creatToken('API-TOKEN')->plainTextToken;
            return response() -> json([
                'status' => 'ok',
                'message' => 'Login Successful',
                'token' => $token,
            ],200);
        }
    } catch (\Throwable $error){
        return response()->json([
            'status' => 'Error',
            'message' => $error -> getMessage(),
        ],500);
    }
  }
}
