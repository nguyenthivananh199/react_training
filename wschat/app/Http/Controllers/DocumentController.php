<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Document;
use App\Models\Lesson;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    //
    function store(Request $request){
        return $request;
        if (!$request->hasFile('file')) {
            // Nếu không thì in ra thông báo
            return "Mời chọn file cần upload";
        }else{
            $file = $request->file('file');
           // $name  = 
            $path = Storage::putFile('document', $file);
            return $path;
            // Storage::disk('local')->put('avatar/1', file_get_contents($file));

            return 'yup';
        }

    }
    function getVideo(Request $request,$id) {
        $lesson=Lesson::find($id);

         $tmpLink="/".$lesson->video;
        $video = Storage::disk('local')->get($tmpLink);
        $response = Response::make($video, 200);
        $response->header('Content-Type', 'video/mp4');
        return $response;
    }
    function downloadFile(){
        $file=storage_path('app').'/avatars/pp.pptx';
        $headers = [
            //  'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        return response()->download($file, 'pp.pptx', $headers);
    }

}
