<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthCTR extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name'  => 'required|string' , 
            'email' => 'required|string|unique:users,email' ,//|confirmed //  the form should has another input with email_confirmation 
            'password' => 'required|string' // |confirmed'   // the form should has another input with password_confirmation 
        ]);
        $user = User::create([
            'name'  => $fields['name'] , 
            'email' => $fields['email'] ,
            'password' => bcrypt($fields['password'])
        ]);
        $token = $user->createToken('userToken')->plainTextToken;
        $response = [
            'user' => $user ,
            'token'=> $token
        ];
        return response($response , 201);
    }
        public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string' ,
            'password' => 'required|string'
        ]);
        
        $user = User::where('email' , $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'] , $user->password)) {

            return response([
                'message' => 'wrong email or password'
            ]);
        }
        $token = $user->createToken('userToken')->plainTextToken;
        $response = [
            'user' => $user ,
            'token'=> $token
        ];
        return response($response , 201);
    }
    public function logout(){
        auth()->user()->tokens()->delete();
        return [
            'message' => 'logged out successfully !!'
        ];
    }
}
