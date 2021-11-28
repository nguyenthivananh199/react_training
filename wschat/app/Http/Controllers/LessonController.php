<?php

namespace App\Http\Controllers;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;


class LessonController extends Controller
{
    //
    function detail(Request $request,$id){
        $lesson=Lesson::find($id);
        return $lesson;
    }
    function store(Request $request){
        $lesson= new Lesson();
        $lesson->title=$request->title;
        $lesson->summary=$request->summary;
        $lesson->course_id=$request->courseId;
        $count=Lesson::where("course_id",$request->courseId)
        ->where("lessonActive",'1')->count();
        $lesson->lessonIndex=$count;
        $lesson->lessonActive='1';
        // upload file
        if (!$request->hasFile('file')) {
            // Nếu không thì in ra thông báo
            return "Mời chọn file cần upload";
        }else{
            $file = $request->file('file');
           // $name  = 
            $path = Storage::putFile('lessons', $file);
            // Storage::disk('local')->put('avatar/1', file_get_contents($file));
            $lesson->video= $path;
            $lesson->save();
            return 'yup';
        }

       
        

    }
    function update(Request $request,$id){
        // file take care
        $lesson=Lesson::find($id);
        $lesson->title=$request->title;
        $lesson->summary=$request->summary;
        if (!$request->hasFile('file')) {
            // Nếu không thì in ra thông báo
            $lesson->save();
            return 'khong co file';
        }else{
            Storage::delete($lesson['video']);
            $file = $request->file('file');
           // $name  = 
            $path = Storage::putFile('lessons', $file);
            // Storage::disk('local')->put('avatar/1', file_get_contents($file));
            $lesson->video= $path;
            $lesson->save();
            return 'yup';
        }
       
        return response()->json([
            'message' => 'sucess'], 200);
    }
    function delete($id){
        Lesson::find($id)->update(['lessonActive' => '0']);
        return response()->json([
            'message' => 'sucess'], 200);
    }
}
