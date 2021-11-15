<?php

namespace App\Http\Controllers;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Lesson;
class LessonController extends Controller
{
    //
    function store(Request $request,$id){
        $lesson= new Lesson();
        $lesson->title=$request->title;
        $lesson->summary=$request->summary;
        $lesson->video=$request->video;
        $lesson->course_id=$id;
        $lesson->lessonActive='1';
        $lesson->save();
        return response()->json([
            'message' => 'sucess'], 200);

    }
    function update(Request $request,$id){
        Lesson::find($id)->update($request->toArray());
        return response()->json([
            'message' => 'sucess'], 200);
    }
    function delete($id){
        Lesson::find($id)->update(['lessonActive' => '0']);
        return response()->json([
            'message' => 'sucess'], 200);
    }
}
