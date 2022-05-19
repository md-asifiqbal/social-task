<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
class PageController extends Controller
{
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * User Page Create
     */
    public function create(Request $request)
    {
        $validate=$this->validate($request,[
            'page_name'=>'required|string|max:255'
        ]);
        try {
            Page::create(['page_name'=>$request->page_name,'user_id'=>auth()->id()]);
            $this->apiSuccess(__("Page Create Successfuly"),[]);
            
        } catch (\Exception $e) {
            $this->message=$this->getError();
        }
        
       return $this->apiOutput();
    }

    
}
