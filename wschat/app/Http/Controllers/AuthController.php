<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\RegisterRequest;
class AuthController extends Controller
{
    //
    function register(Request $request){
        $user= User::create([
            'name'=> $request->input('name'),
            'email'=> $request->input('email'),
            'password'=> Hash::make ($request->input('password')),
            'api_token'=>Str::random(60)
        ]);
        return $user;

    }

    function login( Request $request){
        $user_exist = User::where('email', $request->email)->first();
        if(isset($user_exist->id) && Hash::check($request->password, $user_exist->password)){
            return response()
            ->json(['user' => $user_exist]);
        }else{
            return response()->json([
                'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
        }

    }
}
