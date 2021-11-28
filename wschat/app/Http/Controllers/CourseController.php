<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    //
    function list(){
        $listCourses=array();
        $list= Course::with('lessons_active')->with('member_course_active')->get();
        // for($i=0;$i<count($list);$i++){
        //     $tmp=Course::find($list[$i]['id'])->lessons_active;
        //     array_push($listCourses, $tmp);
        //     $listCourses[$i]->append($list[$i]);
        // }
        return $list;
    }
    function store(Request $request){

        $course= new Course();
        $course->courseName=$request->courseName;
        $course->courseStatus=$request->courseStatus;
        $course->courseActive='1';
        $course->courseDescription=$request->courseDescription;
        $course->courseLevel= $request->courseLevel;
        $course->courseSubject=$request->courseSubject;
        $course->user_id =Auth::id();
        $course->save();
        return response()->json([
            'message' => 'ok'], 200);   

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
        $lesson= Lesson::where('course_id',$id)->where("lessonActive",'1')->get();
        return response()
            ->json(['course' => $course,'lessons'=>$lesson]);
    }

}
