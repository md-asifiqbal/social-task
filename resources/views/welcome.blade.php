<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Social Task</title>
  </head>
  <body>
   <div class="container">
    <div class="row">
        
    </div>
       <div class="row mt-5 ">
       <div class="col-md-5 offset-3 ">
         <div class="card p-3">
        <div class="card-header text-center mb-3"><h3>Social Login</h3></div>
          

  <div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text text-danger d-none"></div>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password">
  </div>

  <button type="button" onclick="login()" class="btn btn-primary mb-3">Login</button>
</div>
       </div>
   </div>
   </div>

   <script type="text/javascript">

    class Auth{      
        //Login User
          login(email, password){
            fetch('/api/auth/login', {
              headers: { "Content-Type": "application/json; Accept: application/json" },
              method: 'POST',
              body: JSON.stringify({
                email: email,
                password: password,
              })
            })
          .then(response => response.json())
          .then(json =>{
            if(json.status){
              localStorage.setItem("token",json.api_token);
              window.location.href="/feed"  
            }else{
                document.getElementById('emailHelp').classList.remove("d-none");
                document.getElementById('emailHelp').classList.add("d-block");
                document.getElementById('emailHelp').textContent=json.message;
            }
            }

          );
          

            }
            }

            //login form submit
        function login(){
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            if(password=="" || email==""){
                document.getElementById('emailHelp').classList.remove("d-none");
                document.getElementById('emailHelp').classList.add("d-block");
                document.getElementById('emailHelp').textContent="Email or Password Field is Required";
            }

            let authentication=new Auth();
            authentication.login(email,password);
        }
   </script>


  </body>
</html>