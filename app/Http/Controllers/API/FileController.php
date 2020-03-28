<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Filee;
use Illuminate\Http\Request;

class FileController extends Controller
{
    //
    public function files($id){
    return    Filee::where('projet_id',$id)->latest()->paginate(100);
    }
    public function formSubmit(Request $request,$id)
    {
        $this->validate($request,[
          'file' => 'required|mimes:doc,docx,pdf,txt|max:2048'
        ]);
        $extention= time().'.'.$request->file->getClientOriginalExtension();
        $fileName =$request->name.'.'.$extention;
        $request->file->move(public_path('upload'), $fileName);
        $filetable=new Filee;
        $filetable->file= $fileName;
        $filetable->projet_id=$id;
        $filetable->save();
        return response()->json(['success'=>'You have successfully upload file.']);
    }
}
