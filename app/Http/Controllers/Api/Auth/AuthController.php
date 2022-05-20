<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    //User Registration
    public function register(RegisterRequest $request)
    {
        $input=$request->validated();
        $input['password']=bcrypt($request->password);
       $user=User::create($input);
       $this->apiSuccess(__("User Registration Successfuly"),$user);
       return $this->apiOutput();
    }

    //User Registration
    public function login(Request $request)
    {
       $user=User::where('email',$request->email)->first();
       if($user && Hash::check($request->password,$user->password)){
        $this->api_token=$user->createToken($user->email)->plainTextToken;
        $this->apiSuccess(__("User Login Successfuly"),$user);
       }else{
        $this->status=false;
        $this->code=403;
        $this->message="Email or Password may be wrong";
       }
       
       return $this->apiOutput();
    }

    public function me(Request $request){
        $this->apiSuccess(__("User Information"),auth()->user());
         return $this->apiOutput();
    }
}
