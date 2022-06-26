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
        $data = teacherModel::orderBy('id','Asc')->get();
        return response()->json($data);
    }
    // -------------------Store Data-----------------
   public function storeData(Request $request){

            $request->validate([
                'name' =>'required',
                'title' =>'required',
                'institute' =>'required',
            ]);

            $name = $request->input('name');
            $title = $request->input('title');
            $institute = $request->input('institute');
            $result= teacherModel::insert(['name'=>$name,'title'=>$title,'institute'=>$institute]);
        return response()->json($result);
    }
    // -----------------------edit data-----------------------
    public function editData($id){
        $data = teacherModel::findOrFail($id);
        return response()->json($data);
    }

    // ------------------------Update Data-----------------------

    public function updateData(Request $request,$id){
        $request->validate([
            'name' =>'required',
            'title' =>'required',
            'institute' =>'required',
        ]);
        $name = $request->input('name');
        $title = $request->input('title');
        $institute = $request->input('institute');
       // $result= teacherModel::findOrFail()->update(['id'=>$id, 'name'=>$name,'title'=>$title,'institute'=>$institute]);
        $result= teacherModel::where('id',$id)->update(['name'=>$name,'title'=>$title,'institute'=>$institute]);
    return response()->json($result);
    }

    public function deleteData(Request $request,$id){
        $id= $request->input('id');
        $result= teacherModel::where('id',$id)->delete();
        return response()->json($result);
    }
}
