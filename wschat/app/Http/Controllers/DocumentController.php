<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Document;
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
    function downloadFile(){
        $file=storage_path('app').'/avatars/pp.pptx';
        $headers = [
            //  'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        return response()->download($file, 'pp.pptx', $headers);
    }

}
