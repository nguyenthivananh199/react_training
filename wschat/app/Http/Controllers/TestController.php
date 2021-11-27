<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quizz_history;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    function list(){
        return Test::where('testActive','1')->get();
    }
    function store(Request $request){
        $test= new Test();
        $test->level= $request->level;
        $test->subject= $request->subject;
        $test->description= $request->description;
        $test->name=$request->name;
        $test->time=$request->time;
        $test->testActive=1;
        $test->save();
        // save questions
        $questions= $request->questions;
        for($i =0; $i< count($questions);$i++){
            $question= new Question();
            $question->test_id=$test->id;
            $question->question= $questions[$i]["question"];
            $question->type=$questions[$i]["type"];
            $question->ans1=$questions[$i]["answers"][0];
            $question->ans2=$questions[$i]["answers"][1];
            $question->ans3=$questions[$i]["answers"][2];
            $question->ans4=$questions[$i]["answers"][3];
            $question->correctAns= $questions[$i]["correct"];
            $question->explaination= $questions[$i]["explaination"];
            $question->save();

        }
        return response()->json([
            'message' => 'sucess'], 200);
    }
    function update(Request $request,$id){
        $test=Test::find($id);
        $test->level= $request->level;
        $test->subject= $request->subject;
        $test->description= $request->description;
        $test->name=$request->name;
        $test->time=$request->time;
        $questions= $request->questions;
        $tmp=array();
        $updateQuest=array();
        for($i =0; $i< count($questions);$i++){
            if($questions[$i]['questionId']!=-1){
        //    $tmp.push($questions[$i]['id']);
           array_push($tmp, $questions[$i]['questionId']);
           array_push($updateQuest, $questions[$i]);

            }

        }
        $q=Question::where("test_id",$id)->whereNotIn('id', $tmp)->get();
        for($i =0; $i< count($q);$i++){
            
           Question::find($q[$i]['id'])->delete();

        }
        for($i =0; $i< count($updateQuest);$i++){
           // update old question
           $oldQues=Question::find($updateQuest[$i]['questionId']);
           $oldQues->question=$updateQuest[$i]["question"];
           $oldQues->correctAns=$updateQuest[$i]['correct'];
           $oldQues->ans1=$updateQuest[$i]['answers'][0];
           $oldQues->ans2=$updateQuest[$i]['answers'][1];
           $oldQues->ans3=$updateQuest[$i]['answers'][2];
           $oldQues->ans4=$updateQuest[$i]['answers'][3];
           $oldQues->explaination= $updateQuest[$i]["explaination"];
           $oldQues->type=$updateQuest[$i]["type"];
           $oldQues->save();

        }
        for($i =0; $i< count($questions);$i++){
            if($questions[$i]['questionId']==-1){
                // tao moi cau
                $newQuestion=new Question();
                $newQuestion->test_id=$id;
                $newQuestion->question=$questions[$i]['question'];
                $newQuestion->correctAns=$questions[$i]['correct'];
                $newQuestion->ans1=$questions[$i]['answers'][0];
                $newQuestion->ans2=$questions[$i]['answers'][1];
                $newQuestion->ans3=$questions[$i]['answers'][2];
                $newQuestion->ans4=$questions[$i]['answers'][3];
                $newQuestion->explaination= $questions[$i]["explaination"];
                $newQuestion->type=$questions[$i]["type"];
                $newQuestion->save();

            }

        }
        
        return response()->json([
           'oki'], 200);
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
    function insertHistory(Request $request){
        $history= Quizz_history::create($request->toArray());
        return response()->json([
            'message' => 'sucess'], 200);
    }
}
