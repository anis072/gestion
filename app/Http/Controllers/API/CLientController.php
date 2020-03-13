<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Client;
use App\Projet;
use Validator;

use App\Mail\ClientMail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CLientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Client::latest()->paginate(15);

    }
    public function clientprojet(){

        return Client::latest()->paginate(100);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
$this->validate($request, [

              'name' => 'required|string|max:50',
              'email' => 'required|string|email|unique:users',
              'password' => 'required|string|min:6',
              "tel" =>'required'
          ]);



        return Client::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),
            'tel'=> $request->tel

        ]);

        Mail::to($request->email)->send(new ClientMail($request->password));
    }
    public function nomdeprojet(Request $request){
         $data =$request->all();
         $client = Client::get();

        return  $projets=Projet::where('id',$client->id);


    }
    public function updatename(Request $request ){
   $data =$request->all();
   Client::where('id',$data['client_id'])->update(['project_name'=>$data['client_id']]);
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
    public function owner(){
        return Client::all();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        $client->update($request->all());
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
        $client=Client::find($id);
        $client->delete();
    }
}
