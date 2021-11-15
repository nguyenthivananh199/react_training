<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserController extends Controller
{
    //
    function index(){
        return User::where("userActive","1")->get();
    }
    function store(Request $request){
        $user= User::create([
            'name'=> $request->input('name'),
            'email'=> $request->input('email'),
            'password'=> Hash::make ($request->input('password')),
            'api_token'=>Str::random(60),
            'userActive'=>"1"
        ]);
        return response()->json([
            'message' => 'sucess'], 200);
    }
    function update(Request $request, $id){
        $user =User::find($id);
        $user->name =$request->name;
        $checkEmail= User::where('email','!=',$user->email)
        ->where('email',$request->email)->get();
        if(count($checkEmail)!=0){
            return response()->json([
                'message' => 'email s already used'], 400);
        }
        $user->email= $request->email;
        if(Hash::check($request->password, $user->password)){
            $user->password= $request->password;
        }else{
            $user->password= Hash::make ($request->password);
        }
        $user->save();
        return response()->json([
            'message' => 'update successfully'], 200);


    }
    function delete($id){
        User::find($id)->update(['userActive' => '0']);
        return response()->json([
            'message' => 'delete successfully'], 200);
    }

}
