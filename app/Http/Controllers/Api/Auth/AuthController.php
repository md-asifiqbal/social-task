<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
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
    public function login(LoginRequest $request)
    {
       $user=User::where('email',$request->email)->first();
       if($user){
        $this->api_token=$user->createToken($user->email)->plainTextToken;
        $this->apiSuccess(__("User Login Successfuly"),$user);
       }else{
        $this->status=false;
        $this->message="Email or Password may be wrong";
       }
       
       return $this->apiOutput();
    }
}
