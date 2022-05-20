@extends('layouts.app')

@section('content')
   <div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-12 ">
          <div class="row nav text-center bg-primary text-white">
            <h3>Social Media</h3>
          </div>

          <div class="row">
            <div class="col-md-3">
        
              <div class="input-group mt-3 mb-3"  style="width: 18rem;">
  <input type="text" class="form-control" placeholder="Page Name" id="page_name" aria-label="Recipient's username" aria-describedby="button-addon2">
  <button class="btn btn-success text-white btn-outline-secondary" type="button" id="button-addon2" onclick="createPage()" >Save</button>
</div>





              <div class="card" style="width: 18rem;">
                <div class="card-header bg-secondary text-white">
                Your Pages
              </div>
              <ul class="list-group" id="mypages">
              
            </ul>           
            </div>

            <div class="card mt-3"  style="width: 18rem;">
                    <div class="card-header">
                      Create Post From Page
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group mb-3">
                            <textarea placeholder="What's on your mind?" class="form-control" id="post_content_page" rows="3"></textarea>
                          </div>
                          <div class="form-group mb-3">
                            <select name="page" id="page" class="form-control">
                             
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer"><button onclick="createPostFromPage()" class="btn btn-primary" style="float: right;">Post</button></div>
                  </div>

           

            </div>
            <div class="col-md-6">
              <div class="row m-2">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      Create Post
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <textarea placeholder="What's on your mind?" class="form-control" id="post_content" rows="3"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer"><button onclick="createPost()" class="btn btn-primary" style="float: right;">Post</button></div>
                  </div>
                </div>
              </div>
              <div class="post" id="post">
               
              </div>


            </div>
            <div class="col-md-3">
              <div class="card" style="width: 17rem;">
                <div class="card-header bg-secondary text-white">
                People You May Know
              </div>
              <ul class="list-group" id="peoples">
              
            </ul>
              

            </div>

             <div class="card mt-3" style="width: 18rem;">
                <div class="card-header bg-secondary text-white">
                All Pages
              </div>
              <ul class="list-group" id="allpages">
            
            </ul>           
            </div>

            
            </div>
          </div>
        </div>
      </div>
     
   </div>

@endsection

@push('script')
   <script type="text/javascript">
    load(); //Load all function 

        function load(){
          let feed=new Feed();
          feed.feed(); //Get login user newsfeed
          feed.persons(); //Get all registered user
          feed.pages('user','mypages');
          feed.pages('all','allpages');
          feed.pagesSelect();
        }


        

        //create login user post
        function createPost(){
          var post_content = document.getElementById('post_content').value;
          if(post_content=="")
            return;
          let feed=new Feed();
          feed.createPost(post_content);
          document.getElementById('post_content').value='';
        }

        //create post from page

        function createPostFromPage(){
          var post_content_page = document.getElementById('post_content_page').value;
          var page = document.getElementById('page').value;

          if(post_content_page=="" || page=="")
            return;
          let feed=new Feed();
          feed.createPostPage(post_content_page,page);
          document.getElementById('post_content_page').value='';
        }



        //Toggole follow by login user

        function toggleFollow(id){
          let feed=new Feed();
            feed.follow(id);
        }

        //Toggole Page follow by login user

        function togglePageFollow(id){
          let feed=new Feed();
            feed.pageFollow(id);
        }

        //Create Page

        function createPage(){
          var page_name = document.getElementById('page_name').value;
          if(page_name=="")
            return;
          let feed=new Feed();
          feed.createPage(page_name);
          document.getElementById('page_name').value='';
        }
        
   </script>
   @endpush
