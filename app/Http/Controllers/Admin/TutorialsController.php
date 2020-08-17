<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tutorial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TutorialsController extends Controller
{
    public function create()
    {
        $levels = Tutorial::getLevelTutorials();
        $tutorials = Tutorial::all()->groupBy("level")->toArray();

        return view("admin.tutorials.create", compact("levels", "tutorials"));
    }

    public function store(Request $request)
    {

        $file = $request->file('src');
        $fullname = time() . '.' . $file->getClientOriginalExtension();
        $typesImage = [
            'jpeg',
            'jpg',
            'png',
            'gif',
        ];

        if (in_array($file->getClientOriginalExtension(), $typesImage)) {
            $typeMedia = "image";
        } else {
            $typeMedia = "video";
        }

      
        $path = public_path() . "/tutorials/".$typeMedia."/";
        $file->move($path, $fullname);






        Tutorial::create([
            "title" => $request->input('title'),
            "description" => $request->input('description'),
            'format' => $typeMedia,
            "src" =>$fullname,
            "level" =>$request->input('level'),
        ]);

        flash_message("با موفقیت ثبت شد !","success");
        return back();
    }
}
