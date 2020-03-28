<?php

namespace App\Http\Controllers\API;

use App\Client;
use App\Projet;
use App\User;
use App\userprojet;
use App\Http\Controllers\BaseController ;
use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Auth;

class ProjetController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Projet::latest()->paginate(8);

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getProjectsUserConnecte(){
      //  $user = User::with('projets');
        //return $user->projets;
         
  //$user=User::where('id',4)->first();
 // $user=Auth::user();
  return auth()->user()->projects;
    }


     public function store(Request $request)
    {
        //


        $this->validate($request,[

            'name' => 'required|string|max:50',
            'durre' =>  'required|string|max:50',
            'description'=>'required|string|max:2250',
            'client_id' => 'required',
            'budget' => 'required',
              ]);


          $data = $request->all();
           $client = Client::where('id', $data['client_id'])->first();
           $projet =new Projet;
            $projet->name = $data['name'];
            $projet->durre = $data['durre'];
            $projet->description = $data['description'];
            $projet->client_id = $data['client_id'];
            $projet->owner = $client->name;
            $projet->budget = $data['budget'];
            $projet->save();
       }




    public function getProjects()
    {
      return Projet::latest()->paginate(15);

    }
    public function getid(){
        $clients=Client::get();
        $projets =Projet::where(['client_id' => $clients->id])->get();
        foreach($projets as $projet){
            foreach($clients as $client){
          $projet->owner=$client->name;
        }
    }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   $data =$request->all();
        $this->validate($request,[

            'name' => 'required|string|max:50',
            'durre' =>  'required|string|max:50',
            'description'=>'required|string|max:250',
            'client_id' => 'required',
            'budget' => 'required',

         ]);

        //


       $client = Client::where('id', $data['client_id'])->first();

        DB::table('projets')->where('id',$id)->update(['name'=>$data['name'],'durre'=>$data['durre'],'description'=>$data['description'],'owner'=>$client->name,'client_id'=>$data['client_id'],'budget'=>$data['budget']]);

        $chef = User::where('id' , $request->chefprojet)->first();
        DB::table('user_projet')->update(['user_id'=>$chef->id,'membre'=>$chef->name,'role'=>$chef->role]);


    }

    public function updateparchef(Request $request, $id)
    {


        $data =$request->all();


        //


        $client = Client::where('id', $data['client_id'])->first();

        DB::table('projets')->where('id',$id)->update(['name'=>$data['name'],'durre'=>$data['durre'],'description'=>$data['description'],'owner'=>$client->name,'client_id'=>$data['client_id'],'budget'=>$data['budget']]);



    }

    //

    public function role(Request $request){
        $data =$request->all();
        $role =new Role;
        $role->role=$data['role'];
        $role->save();
    }
    public function getrole(Request $request){
        return Role::latest()->paginate(100);
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
        $projet=Projet::find($id);
        $projet->delete();
        return ["result" => "Projet Deleted"];
    }
}
