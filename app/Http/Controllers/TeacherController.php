<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\teacherModel;

class TeacherController extends Controller
{
    function Index(){
        return view('Teacher');
    }
    // -------------------All Data-----------------
    public function allData(){
        $data = teacherModel::orderBy('id','Desc')->get();
        return response()->json($data);
    }
    // -------------------Store Data-----------------
   public function storeData(Request $request){
            $name = $request->input('name');
            $title = $request->input('title');
            $institute = $request->input('institute');
            $result= teacherModel::insert(['name'=>$name,'title'=>$title,'institute'=>$institute]);
        return response()->json($result);
    }
}
