<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function login(LoginRequest $request){

        $user = User::where('email', $request->email)->first();
   
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }    
        
        return $this->success('',["token" => $user->createToken($request->email)->plainTextToken]);
    }

    public function register(){

    }
    public function logout()
    {

    }

    public function changePassword(){
        
    }

    public function user(Request $request){
        return new UserResource($request->user());
    }
}
