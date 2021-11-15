<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Test;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    function list(){
        return Test::where('testActive','1')->get();
    }
    function store(Request $request){
        $test= Test::create($request->toArray());
        return response()->json([
            'message' => 'sucess'], 200);
    }
    function update(Request $request,$id){
        Test::find($id)->update($request->toArray());
        return response()->json([
            'message' => 'sucess'], 200);
    }
    function delete($id){
        Test::find($id)->update(['testActive' => '0']);
        return response()->json([
            'message' => 'sucess'], 200);
    }
    function getDetail($id){
        $testDetail=Test::find($id);
        $question=$testDetail->questions;
        return response()
            ->json(['test' => $testDetail]);

    }
    function deleteQuestion($id){
        Question::destroy($id);
        return response()->json([
            'message' => 'sucess'], 200);
    }
    function storeQuestion(Request $request){
        $question= Question::create($request->toArray());
        return response()->json([
            'message' => 'sucess'], 200);
    }
    function updateQuestion(Request $request, $id){
        Question::find($id)->update($request->toArray());
        return response()->json([
            'message' => 'sucess'], 200);
    }
}
