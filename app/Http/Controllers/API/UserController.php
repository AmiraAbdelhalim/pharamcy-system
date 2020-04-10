<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use Illuminate\Foundation\Auth\VerifiesEmails;


class UserController extends Controller
{

    use VerifiesEmails;
    //get all users
    public function index(){
        return User::all();
    }

    //get one user
    public function show($user){
        return response()->json([
            'message'=>"you are not autherized"
        ]);
        return new UserResource(User::find($user));
    }

    //create new user
    public function store(UserRequest $request){
        
       //hash password
        $request['password']=Hash::make($request->password);
        $request['password_confirmation']=Hash::make($request->password_confirmation);

        
        // storing image in public/pics and changes its name
        if ($request->hasfile('profile_pic')){
            $file=$request->file('profile_pic');
            $extention=$file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move('pics/',$filename);
        }
        $request->profile_pic=$filename;
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'password_confirmation'=>$request->password_confirmation,
            'profile_pic'=>$request->profile_pic,
            'national_id'=>$request->national_id,
            'gender'=>$request->gender,
            'mobile'=>$request->mobile,
            'is_admin'=>$request->is_admin,
            'birth_date'=>$request->birth_date

        ]);
        // verification
        $user->sendApiEmailVerificationNotification();
        $success["message"] = "Please confirm yourself by clicking on verify user button sent to you on your email";
        return response()->json(["success"=>$success], 201);//201 objected created
    }



    //put function
    public function update(UpdateUserRequest $request,$user)
    {
       //check if autherized user and updates only his data
        if ($user != auth()->user()->id){
            return response()->json([
                'message'=>"you are not autherized"
            ]);
       }
       if($request->email){
            return response()->json([
                'message'=>"you cannot change email"
            ]);
       }
    //    dd($request->all());
        $request['password']=Hash::make($request->password);
        $request['password_confirmation']=Hash::make($request->password_confirmation);
        if ($request->hasfile('profile_pic')){
            $file=$request->file('profile_pic');
            $extention=$file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move('pics/',$filename);
            // $request->profile_pic=$filename;
        
        }
        
        User::find($user)->update([
            'name'=>$request->name,
            'password'=>$request->password,
            'password_confirmation'=>$request->password_confirmation,
            'profile_pic'=>$filename,
            'national_id'=>$request->national_id,
            'gender'=>$request->gender,
            'mobile'=>$request->mobile,
            'birth_date'=>$request->birth_date

        ]);

        return response()->json($user, 200);
    }

    //delete incase we needed it 
    public function destroy(Request $request, $user){
        
        $user=User::find($user);


        $user->delete();

        return response()->json("user deleted", 204);//204 action executed successfully but no content to return
    }


   
}
