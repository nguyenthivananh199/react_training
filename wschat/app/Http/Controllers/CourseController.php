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
        return Course::where('active','1')->get();
    }
    function store(Request $request){

        // $course= new Course();
        // $course->courseName=$request->courseName;
        // $course->courseStatus=$request->courseStatus;
        // $course->courseActive='1';
        // $course->courseDescription=$request->courseDescription;
        // $course->courseLevel= $request->courseLevel;
        // $course->courseSubject=$request->courseSubject;
        // $course->user_id =Auth::id();
        // $course->save();
        if (!$request->hasFile('file0')) {
            // Nếu không thì in ra thông báo
            return response()->json([
                'message' => 'ok'], 200);
        }else{
            // thêm lesson
            $i=0;
            $fileName='file'.$i;
            while($request->hasFile('file'.$i)){
                
                $i++;

            }
            return response()->json([
                'message' => $i], 200);
        }
            // $file = $request->file('file0');
            

        
       
       

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
