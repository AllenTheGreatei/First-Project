@extends('__partials.commonMaster')

@section('title', 'Change Password - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection


@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register Card -->
      <div class="card">
        <div class="card-body">
          <div class="mb-3 p-3">
            <form id="changepassform" class="mb-3" action="{{url('/')}}" method="GET">
              <h5 class="fw-bold text-primary">Change Password</h5>
              <div class="mb-3 mt-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control mb-1" id="email" name="email" disabled autofocus value="{{ session('email')}}">
              </div>
              <div class="mb-3 mt-4">
                <label for="newpassword" class="form-label">New Password</label>
                <input type="password" class="form-control mb-1 newpassword" id="password" name="newpassword" autofocus>
              </div>
              <div class="mb-3">
                <label for="retypepassword" class="form-label">Retype Password</label>
                <input type="password" class="form-control mb-1 retype-password" id="retype-password" name="retypepassword" autofocus>
              </div>
              <div class="row password-requirements" style ="display:flex;flex-direction:column;display:none;color:grey;padding:.5em;background-color:#f4f4f4;border-radius:6px">
                <span>Password must contain :</span>
                <li id ="capital">at least one capital letter</li>
                <li id ="small">at least one small letter</li>
                <li id ="number">at least one number</li>
                <li id ="eight_char">at least 8 characters</li>
                <li id ="special">at least one special character</li>
            </div>
              <button class="btn btn-primary mt-4 d-grid w-100" id="change_pass">Save</button>
            </form>
          </div>
        </div>
      </div>
      <!-- Register Card -->
    </div>
  </div>
</div>
@extends('__partials.footer')
@endsection
