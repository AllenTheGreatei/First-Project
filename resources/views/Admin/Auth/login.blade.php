@extends('__partials.commonMaster')

@section('title', 'Login - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card" style="padding: 3em 1em;width:28vw">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/#')}}" style="text-decoration:none" class="app-brand-link gap-2">
              {{-- <span class="app-brand-logo demo">@include('__partials.macros',["width"=>25,"withbg"=>'var(--bs-primary)'])</span> --}}
              <span class="app-brand-text demo text-body fw-bold text-capitalize">{{ "Admin Login"}}</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2"></h4>
          <p class="mb-4"></p>

          <form id="admin-login-form" class="mb-3" action="{{url('/')}}" method="GET">
            <div class="mb-3">
              <label for="email" class="form-label">Email or Username <span style="color:red"> *</span></label>
              <input type="text" class="form-control inputs" id="admin-email" name="admin-email" placeholder="Enter your email or username" autofocus>
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password<span style="color:red"> *</span></label>
                <a href="{{url('auth/forgot-password-basic')}}">
                  {{-- <small>Forgot Password?</small> --}}
                </a>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="admin-password" class="form-control inputs" name="admin-password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="mb-3">
              <div class="form-check">
                {{-- <input class="form-check-input" type="checkbox" id="remember-me"> --}}
                <label class="form-check-label" for="remember-me">
                  {{-- Remember Me --}}
                </label>
              </div>
            </div>
            {{-- Login with Google --}}
           
            <p id="admin-max-attempt" style="color:red"></p>
            <div class="mb-3">
              <button class="btn btn-dark d-grid w-100" id="admin-login-btn"type="submit">Login</button>
              <h6 style="text-align:center;margin:.5em 0">or</h6>
            </div>
            <div id="g_id_onload"
            data-client_id="{{env('GOOGLE_CLIENT_ID')}}"
            data-callback="onSignIn"></div>
      <div class="g_id_signin form-control" data-type="standard"></div>
          </form>

          <p class="text-center">
            {{-- <span>New on our Website?</span>
            <a href="{{url('register')}}">
              <span>Create an account</span>
            </a> --}}
          </p>
        </div>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
</div>
@endsection
@extends('__partials.footer')
<script src="{{asset('new_js/jquery-3.7.1.min.js')}}"></script>
<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
  var dashboardRoute = '{{ route("dashboardbtn") }}';
  console.log('test')
    function decodeJwtResponse(token) {
    let base64Url = token.split('.')[1];
    let base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    let jsonPayload = decodeURIComponent(
      atob(base64)
        .split('')
        .map(function (c) {
          return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        })
        .join('')
    );
    return JSON.parse(jsonPayload);
  }
  window.onSignIn = googleUser => {
    var user = decodeJwtResponse(googleUser.credential);
    if(user){
      jQuery.noConflict();
      $.ajax({
        url: 'admin-google',
        method: 'post',
        cache: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { email: user.email },
        success: function (data) {
          if(data.message == "success"){
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            iconColor: 'white',
            customClass: {
              popup: 'colored-toast'
            },
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
          });
          Toast.fire({
            icon: 'success',
            title: "Login Sucessfully!"
          });
          window.location.href = 'dashboard';
          }else if(data.message == 'notverified'){
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            iconColor: 'white',
            customClass: {
              popup: 'colored-toast'
            },
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
          });
          Toast.fire({
            icon: 'error',
            title: "Email account not verified!"
          });
          }else{
            console.log(data);
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-right',
              iconColor: 'white',
              customClass: {
                popup: 'colored-toast'
              },
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true
            });
            Toast.fire({
              icon: 'error',
              title: "You Are Not Authorize User."
            });
          }
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText)
        },
      });
    } else {
      alert('Not Valid');
    }
  };
</script>