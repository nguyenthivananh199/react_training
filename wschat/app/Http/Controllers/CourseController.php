<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;

class CourseController extends Controller
{
    //
    function list(){
        return Course::where('active','1')->get();
    }
    function store(Request $request){
        $course= new Course();
        $course->courseName=$request->name;
        $course->courseStatus=$request->status;
        $course->courseActive='1';
        $course->courseDescription=$request->description;
        $course->courseLevel= $request->level;
        $course->courseSubject=$request->subject;
        $course->user_id =$request->user_id;
        $course->save();
        return response()->json([
            'message' => 'sucess'], 200);

    }
    function update(Request $request,$id){
        Course::find($id)->update($request->toArray());
        return response()->json([
            'message' => 'sucess'], 200);
    }

    function delete($id){
        Course::find($id)->update(['courseActive' => '0']);
        Lesson::where('course_id',$id)->update(['lessonActive' => '0']);
        return response()->json([
            'message' => 'sucess'], 200);
    }
    
    function listByMentor($id){
        return Course::where('user_id',$id)->where("courseActive","1")->get();
    }
    function listByMember($id){
        return User::find($id)->course_member_active;
        // return Course::where('user_id',$id)->get();
    }
    function listMember($id){
        return Course::find($id)->member_course_active;
    }
    function detail($id){
        $course=Course::find($id);
        return response()
            ->json(['course' => $course]);
    }

}
