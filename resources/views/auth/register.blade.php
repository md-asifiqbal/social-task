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
                            <div class="card-header text-center mb-3"><h3>Social Registration</h3></div>
                              
                        <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" aria-describedby="emailHelp">
                        <div id="firstnameHelp" class="form-text text-danger d-none"></div>
                      </div>
                      <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" aria-describedby="emailHelp">
                        <div id="lastnameHelp" class="form-text text-danger d-none"></div>
                      </div>
                      <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text text-danger d-none"></div>
                      </div>
                      <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password">
                        <div id="passwordHelp" class="form-text text-danger d-none"></div>
                      </div>
                      <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation">
                      </div>

                      <button type="button" onclick="register()" class="btn btn-primary mb-3">Register</button>
                      <p>Already Have Account? <a href="/login">Click Here</a></p>
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
        function register(){
            var first_name = document.getElementById('first_name').value;
            var last_name = document.getElementById('last_name').value;
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            var password_confirmation = document.getElementById('password_confirmation').value;

            if(email==""){
                document.getElementById('emailHelp').classList.remove("d-none");
                document.getElementById('emailHelp').classList.add("d-block");
                document.getElementById('emailHelp').textContent="Email Field is Required";

                return;
            }else if(password=="" || password_confirmation==""){
              document.getElementById('passwordHelp').classList.remove("d-none");
                document.getElementById('passwordHelp').classList.add("d-block");
                document.getElementById('passwordHelp').textContent="Password or Confirm Password Field is Required";

                return;  
            }
            else if(first_name==""){
              document.getElementById('firstnameHelp').classList.remove("d-none");
                document.getElementById('firstnameHelp').classList.add("d-block");
                document.getElementById('firstnameHelp').textContent="First Name Field is Required";

                return;  
            }
            else if(last_name==""){
              document.getElementById('lastnameHelp').classList.remove("d-none");
                document.getElementById('lastnameHelp').classList.add("d-block");
                document.getElementById('lastnameHelp').textContent="Last Name Field is Required";

                return;  
            }

            if(password != password_confirmation){
                document.getElementById('passwordHelp').classList.remove("d-none");
                document.getElementById('passwordHelp').classList.add("d-block");
                document.getElementById('passwordHelp').textContent="Password and Confirm Password doesn't match";
                returnl
            }

            let authentication=new Auth();
            authentication.register(first_name,last_name,email,password,password_confirmation);
        }
   </script>
   @endpush
