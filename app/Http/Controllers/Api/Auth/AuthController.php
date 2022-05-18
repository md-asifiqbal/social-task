<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
class AuthController extends Controller
{

    //User Registration
    public function register(RegisterRequest $request)
    {
      //  dd($request->validated());
       $data=User::create($request->validated());
       $this->apiSuccess(__("User Registration Successfuly"),$data);
       return $this->apiOutput();
    }
}
