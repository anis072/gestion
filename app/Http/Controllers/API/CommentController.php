<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Commentaire;
use App\Projet;
use App\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function __construct(){

            $this->middleware('auth:api');

    }
    public function store($key){
         //$data =$request->all();
        $projet=Projet::find($key);
         $commentaire =new Commentaire;
         $commentaire->user_id= auth()->user()->id;
         $commentaire->body= request('body');
         $commentaire->comment_user_name=$commentaire->user->name;
        $projet->comments()->save($commentaire);


    }
    public function storereply(Request $request,$key){
        $data =$request->all();
        $user=User::find(Auth()->user()->id);
       $commentaire=Commentaire::find($key);
        $commentairereply =new Commentaire;
        $commentairereply->user_id= auth()->user()->id;
       $commentairereply->body = $data['body'];
       $commentairereply->comment_user_name=$user->name;
       $commentaire->comments()->save($commentairereply);




   }
public function show(){
   // $commentaire =Commentaire::user()->name;
    return  Commentaire::where('commentable_type','App\Projet')->paginate(100);

}
public function showreply(){
    // $commentaire =Commentaire::user()->name;
   $comment=Commentaire::where('commentable_type','App\Commentaire')->latest()->paginate(150);

   return $comment ;
 }
}
