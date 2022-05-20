@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="">

                <div class="card-body">
                     <div class="row mt-5 ">
                           <div class="col-md-5 offset-3 ">
                             <div class="card p-3">
                            <div class="card-header text-center mb-3"><h3>Social Login</h3></div>
                              
                        <div class="alert  d-none"  id="errormsgdiv">
                            <p class="alert-danger d-none" id="errormsg"></p>
                        </div>
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
                      <p>Create an Account? <a href="/register">Click Here</a></p>
                    </div>
                           </div>
                       </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
   <script type="text/javascript">
            //login form submit
        function login(){
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            if(password=="" || email==""){
                document.getElementById('emailHelp').classList.remove("d-none");
                document.getElementById('emailHelp').classList.add("d-block");
                document.getElementById('emailHelp').textContent="Email or Password Field is Required";

                return;
            }

            let authentication=new Auth();
            authentication.login(email,password);
        }
   </script>
   @endpush
