<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Page;
class FollowController extends Controller
{
   public function followPerson(Request $request,$personId)
   {
       $user=User::find($personId);

       if(!$user){
        $this->code=404;
        $this->message="User Not Found.";
       }
       elseif($user->id==auth()->id()){
         $this->code=406;
         $this->message="User can't follow yourself.";
       }else{
        auth()->user()->personFollowers()->syncWithoutDetaching($user);
        $this->apiSuccess(__("User Follow Success"),[]);
       }

         return $this->apiOutput();

   }
   public function followPage(Request $request,$pageId)
   {
       $data=Page::find($pageId);
       
       if(!$data){
        $this->code=404;
        $this->message="Page Not Found.";
       }
       elseif($data->user_id==auth()->id()){
         $this->code=406;
         $this->message="User can't follow his/her own page.";
       }else{
        auth()->user()->pageFollowings()->syncWithoutDetaching($data);
        $this->apiSuccess(__("User Following the Page Successfully"),[]);
       }

         return $this->apiOutput();

   }
}
