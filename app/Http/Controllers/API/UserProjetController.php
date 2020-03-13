<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController ;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Projet;
use App\userprojet;
use App\User;



class UserProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){

             $this->middleware('auth:api');

}
     public function index()
    {
        return Projet::latest()->paginate(15);
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

          $data = $request->all();
          $projet = Projet::latest()->orderBy('created_at','DESC')->first();

          foreach($request->membre_id as $id_mem){
          $membre = User::where('id' , $id_mem)->first();
          $userprojet = new userprojet;
          $userprojet->user_id = $id_mem;
          $userprojet->membre = $membre->name;
          $userprojet->role=$membre->role;
          $userprojet->projet_id = $projet->id;
          $userprojet->name = $projet->name;
          $userprojet->durre = $projet->durre;
          $userprojet->description = $projet->description;
          $userprojet->owner = $projet->owner;
          $userprojet->budget = $projet->budget;
          $userprojet->save();
          }

    }
    public function getProjectsUserConnecte()
    {

    return  userprojet::where('user_id', auth()->user()->id  )->latest()->paginate(200);

    }
    public function storeChef(Request $request){

        $projet = Projet::latest()->orderBy('created_at','DESC')->first();

        $chef = User::where('id' , $request->chefprojet)->first();
        $userprojet = new userprojet;
        /**  if ($this->authorize('Chef')){
             $userprojet->user_id =auth()->user()->id;
            $userprojet->membre = auth()->user()->name;
            $userprojet->role=auth()->user()->role;

            $userprojet->projet_id = $projet->id;
            $userprojet->name = $projet->name;
              $userprojet->durre = $projet->durre;
              $userprojet->description = $projet->description;
              $userprojet->owner = $projet->owner;
              $userprojet->budget = $projet->budget;
            $userprojet->save();

         }*/


        $userprojet->user_id = $chef->id;
        $userprojet->membre = $chef->name;
        $userprojet->role=$chef->role;
        $userprojet->projet_id = $projet->id;
        $userprojet->name = $projet->name;
          $userprojet->durre = $projet->durre;
          $userprojet->description = $projet->description;
          $userprojet->owner = $projet->owner;
          $userprojet->budget = $projet->budget;
        $userprojet->save();




    }
    public function storeChefparchef(){

        $projet = Projet::latest()->orderBy('created_at','DESC')->first();


        $userprojet = new userprojet;
        $userprojet->user_id =auth()->user()->id;
        $userprojet->membre = auth()->user()->name;
        $userprojet->role=auth()->user()->role;
        $userprojet->projet_id = $projet->id;
        $userprojet->name = $projet->name;
          $userprojet->durre = $projet->durre;
          $userprojet->description = $projet->description;
          $userprojet->owner = $projet->owner;
          $userprojet->budget = $projet->budget;
        $userprojet->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        return userprojet::latest()->paginate(100);
    }
    public function showrole(){

    }

    public function Membreprojet()
    {
        return User::latest()->paginate(100);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request inate(150) $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
