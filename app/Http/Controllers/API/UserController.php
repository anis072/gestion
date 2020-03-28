<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Mail\loginMail;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller
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
        //
        return User::where('role','<>','chef de projet')->where('role','<>','admin')->latest()->paginate(100);

    }
    public function chef(){
        return User::where('role','chef de projet')->latest()->paginate(100);
    }
  public function  ajouterChefDeProjet(Request $request){
  $validator= $this->validate($request,[
          'name' => 'required|string|min:3|max:20',
          'email' =>'required|string|email|unique:users',
          'password'=> 'required|string|min:6',
          'Telephone' => 'required'
           ]);

        return User::create([
            'name' => $request->name,
           'email'=> $request->email,
           'password'=> bcrypt($request->password),
           'tel'=> $request->Telephone,
           'role'=> "chef de projet"

       ]);


    }
    public function updateuserconnecté(Request $request){
        $id=Auth()->user()->id;
        $user=User::find($id);
        $user->update(['email'=>$request->email,'password'=>bcrypt($request->password)]);
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
        $this->validate($request,[
            'name' => 'required|string|min:3|max:20',
            'email' =>'required|string|email|unique:users',
            'password'=> 'required|string|min:6',
            'tel' => 'required',
            'role' => 'required'
             ]);

        return User::create([
                'name' => $request->name,
                'email'=> $request->email,
                'password'=> bcrypt($request->password),
                'tel'=> $request->tel,
                'role'=> $request->role

            ]);
            Mail::to($request->email)->send(new loginMail($request->password,$request->role));



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
    public function Membreprojet()
    {
        return User::where('role','<>','admin')->where('role','<>','chef de projet')->latest()->paginate(100);
    }
    public function Membrechefprojet()
    {
        return User::where('role','<>','admin')->latest()->paginate(100);
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
        //

        $user=User::find($id);
         $this->validate($request,[
            'name' => 'required|string|min:3|max:20',
            'email' => 'required|string|email|unique:users,email,'.$user->id,
           'password'=> 'required|string|min:6',
            'tel' => 'required'
             ]);

        $user->update($request->all());
    }
    public function chefprojet(){
    return User::where('role','chef de projet')->latest()->paginate(8);
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
       User::find($id)->delete();
    }
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

       if($request->email != null){
        $this->validate($request,[
            'email' =>'string|email|unique:users',
        ]);
       }
        if($request->password != null){
            $this->validate($request,[
                'password' => 'min:6',
            ]);
        }
            if($request->location != null){
                $this->validate($request,[
                    'location' => 'string|min:6|max:191',
                ]);
            }
                if($request->education != null){
                    $this->validate($request,[
                        'education' => 'string|min:3|max:191',
                    ]);
                    }
                    if($request->education != null){
                    $this->validate($request,[
                        'location' => 'string|min:6|max:191',
                    ]);
                    }

          if($request->photo !=null){


        $currentPhoto = $user->photo;


        if($request->photo != $currentPhoto){
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

            \Image::make($request->photo)->save(public_path('img/profile/').$name);
            $request->merge(['photo' => $name]);
            $userPhoto = public_path('img/profile/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
}

   if($request->email != null){
   $user->email=$request->email;
   $user->save();
  }
  if($request->password != null){
    $user->password=bcrypt($request->password);
    $user->save();
   }
   if($request->education != null){
    $user->education=$request->education;
    $user->save();
   }
   if($request->location != null){
    $user->location=$request->location;
    $user->save();
   }
   if($request->skills != null){
    $user->skills=$request->skills;
    $user->save();
   }
   if($request->photo != null){
    $user->photo=$request->photo;
    $user->save();
   }

        return ['message' => "Success"];
    }
else {

    if($request->email != null){
        $user->email=$request->email;
        $user->save();
       }
       if($request->password != null){
         $user->password=bcrypt($request->password);
         $user->save();
        }
        if($request->education != null){
         $user->education=$request->education;
         $user->save();
        }
        if($request->location != null){
         $user->location=$request->location;
         $user->save();
        }
        if($request->skills != null){
         $user->skills=$request->skills;
         $user->save();
        }
        if($request->photo != null){
         $user->photo=$request->photo;
         $user->save();
        }
}


}
}
