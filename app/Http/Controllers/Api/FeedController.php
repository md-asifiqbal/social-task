<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\PageResource;
class FeedController extends Controller
{

    //Post content into user feed


   public function personAttachPost(Request $request)
   {
         $validate=$this->validate($request,[
            'post_content'=>'required'
        ]);
       $post=auth()->user()->posts()->create(['post_content'=>$request->post_content]);
        $this->apiSuccess(__("Post Create Successfuly"),$post);
        return $this->apiOutput();

   }

   //Post content into user page

   public function pageAttachPost(Request $request,$pageId)
   {
         $validate=$this->validate($request,[
            'post_content'=>'required'
        ]);
         $page=Page::find($pageId);
         if(!$page){
        $this->code=404;
        $this->message="Page Not Found.";
       }
       elseif($page->user_id != auth()->id()){
         $this->code=406;
         $this->message="You don't have a permission to post another user page";
       }else{
        $post=$page->posts()->create(['post_content'=>$request->post_content]);
        $this->apiSuccess(__("Post Create Successfuly"),$post);
       }

        return $this->apiOutput();

   }

   //Get user feed

   public function feed(){
    $feed=auth()->user()->userfeed();
    $this->apiSuccess(__("User Feed"),$feed);
    return $this->apiOutput();
   }

   //Get all users excluding login user

   public function users(){
      $users=User::where('id','<>',auth()->id())->get();
      $this->apiSuccess(__("User Data"),UserResource::collection($users));
    return $this->apiOutput();
   }

   //Get all pages  of login user and also all pages of other user

   public function pages($type=null){
      if($type=='all'){
         $pages=Page::where('user_id','<>',auth()->id())->get();
      }else{
          $pages=Page::where('user_id',auth()->id())->get();
      }
      $this->apiSuccess(__("Pages"),PageResource::collection($pages));
    return $this->apiOutput();
   }
}
