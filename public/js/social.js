class Feed{

    constructor(){
        this.token=localStorage.getItem("token");
        this.loginCheck();

    }
    loginCheck(){
        const authHeaders = {Authorization: 'Bearer ' +this.token,'Accept': 'application/json'};
        fetch("/api/auth/me", {
            headers:authHeaders,
            method: "POST"
           }).then(response => response.json()).then(json => {
            if (!json.status) {
                localStorage.removeItem("token");
                window.location.href = "/login";
            } 
        });
    }
    //Login User newsfeed
    feed() {
        fetch("/api/person/feed", {
            headers: {Authorization: 'Bearer ' +this.token,'Accept': 'application/json'},
            method: "POST",
            body: JSON.stringify({
                post_cotent: "",
            })
        }).then(response => response.json()).then(json => {
            if (json.status) {
                document.getElementById('post').innerHTML='';
                let post='';
                for (let x of json.data) {
                if(x.postable_type=="App\\Models\\User")
                  post+='<div class="card m-3"><div class="card-body"><blockquote class="blockquote mb-0"><p>'+x.post_content+'</p><footer class="blockquote-footer"> <cite title="Source Title">'+x.postable.full_name+'</cite></footer></blockquote></div></div>';
                else
                    post+='<div class="card m-3"><div class="card-body"><blockquote class="blockquote mb-0"><p>'+x.post_content+'</p><footer class="blockquote-footer"> <cite title="Source Title">'+x.postable.page_name+'</cite></footer></blockquote></div></div>';
 
                }
                document.getElementById('post').innerHTML=post;

            } else {
              alert(json.message)
            }
        });
    }

    //Login user create post
    createPost(post_content) {
        fetch("/api/person/attach-post", {
            headers: {Authorization: 'Bearer ' +this.token,'Accept': 'application/json','Content-Type': 'application/json'},
            method: "POST",
            body: JSON.stringify({
                post_content: post_content
            })
        }).then(response => response.json()).then(json => {
            if (json.status) {
               this.feed();
            } else {
                alert(json.message);
            }
        });
    }

    //Get all register user info

    persons(){
        fetch("/api/users", {
            headers: {Authorization: 'Bearer ' +this.token,'Accept': 'application/json'},
            method: "GET"
        }).then(response => response.json()).then(json => {
            if (json.status) {
                document.getElementById('peoples').innerHTML='';
                let post='';
                for (let x of json.data) {
                if(x.follow==0)
                  post+='<li class="list-group-item d-flex justify-content-between align-items-center">'+x.name+'<button onclick="toggleFollow('+x.userId+')" class="btn btn-sm btn-primary rounded-pill">Follow</button></li>';
                else
                  post+='<li class="list-group-item d-flex justify-content-between align-items-center">'+x.name+'<button onclick="toggleFollow('+x.userId+')" class="btn btn-sm btn-primary rounded-pill">Unfollow</button></li>';
 
                }
                document.getElementById('peoples').innerHTML=post;

            } else {
              alert(json.message)
            }
        });
    }

    //login user follow toggle

    follow(id){
      fetch("/api/follow/person/"+id, {
            headers: {Authorization: 'Bearer ' +this.token,'Accept': 'application/json','Content-Type': 'application/json'},
            method: "POST",
            body: JSON.stringify({
            })
        }).then(response => response.json()).then(json => {
            if (json.status) {
               this.persons();
               this.feed();
            } else {
                alert(json.message);
            }
        });  
    }

    //Get all pages

    pages(type,id){
       fetch("/api/pages/"+type, {
            headers: {Authorization: 'Bearer ' +this.token,'Accept': 'application/json'},
            method: "GET"
        }).then(response => response.json()).then(json => {
            if (json.status) {
                document.getElementById(id).innerHTML='';
                let post='';
                for (let x of json.data) {
                if(type=='all'){
                    if(x.follow==0)
                  post+='<li class="list-group-item d-flex justify-content-between align-items-center">'+x.page_name+'<button onclick="togglePageFollow('+x.pageId+')" class="btn btn-sm btn-primary rounded-pill">Follow</button></li>';
                else
                  post+='<li class="list-group-item d-flex justify-content-between align-items-center">'+x.page_name+'<button onclick="togglePageFollow('+x.pageId+')" class="btn btn-sm btn-primary rounded-pill">Unfollow</button></li>';
 
                }else{
                if(x.follow==0)
                  post+='<li class="list-group-item d-flex justify-content-between align-items-center">'+x.page_name+'</li>';
                else
                  post+='<li class="list-group-item d-flex justify-content-between align-items-center">'+x.page_name+'</li>';
 
                }
 
                }
                document.getElementById(id).innerHTML=post;

            } else {
              alert(json.message)
            }
        }); 
    }

    //login user page follow 

    pageFollow(id){
      fetch("/api/follow/page/"+id, {
            headers: {Authorization: 'Bearer ' +this.token,'Accept': 'application/json','Content-Type': 'application/json'},
            method: "POST",
            body: JSON.stringify({
            })
        }).then(response => response.json()).then(json => {
            if (json.status) {
               this.pages('all','allpages');
               this.feed();
            } else {
                alert(json.message);
            }
        });  
    }


    //Login user create page
    createPage(page_name) {
        fetch("/api/page/create", {
            headers: {Authorization: 'Bearer ' +this.token,'Accept': 'application/json','Content-Type': 'application/json'},
            method: "POST",
            body: JSON.stringify({
                page_name: page_name
            })
        }).then(response => response.json()).then(json => {
            if (json.status) {
                this.pages('user','mypages');
               this.feed();
               this.pagesSelect();
            } else {
                alert(json.message);
            }
        });
    }

     //Login user create post from page
    createPostPage(post_content,page) {
        fetch("/api/page/"+page+"/attach-post", {
            headers: {Authorization: 'Bearer ' +this.token,'Accept': 'application/json','Content-Type': 'application/json'},
            method: "POST",
            body: JSON.stringify({
                post_content: post_content
            })
        }).then(response => response.json()).then(json => {
            if (json.status) {
               this.feed();
            } else {
                alert(json.message);
            }
        });
    }

    //Get all pages

    pagesSelect(){
       fetch("/api/pages", {
            headers: {Authorization: 'Bearer ' +this.token,'Accept': 'application/json'},
            method: "GET"
        }).then(response => response.json()).then(json => {
            if (json.status) {
                document.getElementById("page").innerHTML='';
                let post='';
                for (let x of json.data) {
             
                 
                  post+='<option value="'+x.pageId+'">'+x.page_name+'</option>';
 
                
 
                }
                document.getElementById("page").innerHTML=post;

            } else {
              alert(json.message)
            }
        }); 
    }
    
}