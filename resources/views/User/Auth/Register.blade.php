@extends('__partials.commonMaster')

@section('title', 'Register Basic - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection


@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register Card -->
      <div class="card" style="width: 40vw;right:7em;padding:2em 1em">
        <div class="card-body">
          <!-- Logo -->
          <div id ="verifyinfo" class="bg-info pt-2 pb-1 align-items-center justify-content-center rounded mb-3" style="display: none">
            <i class="fa fa-info-circle mr-2" style="font-size:36px;color:white"></i>
            <p class="text-light lead mt-2" style="font-weight:400">We sent an email verification in your email account.</p>
          </div>
          <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="app-brand-link gap-2" style="text-decoration: none">
              {{-- <span class="app-brand-logo demo">@include('__partials.macros',["width"=>25,"withbg"=>'var(--bs-primary)'])</span> --}}
              <span class="app-brand-text demo text-body fw-bold">{{config('variables.templateName')}}</span>
            </a>
          </div>
          <!-- /Logo -->
          
          <h4 class="mb-2">Sign up and Book Now</h4>
          <p class="mb-4"></p>

          <form id="Register_form" class="mb-3" action="{{url('#')}}">
            <label class="form-label">Personal Information</label>
            <hr class="border-dark" style="margin-top: 0;">
            <div class="container">
              <div class="row">
                <div class="col px-0 mr-3">
                  <label for="email" class="form-label">First Name <span class="text-danger"> *</span></label>
                  <input type="text" name="fname" id="fname"class="input form-control">
                </div>
                <div class="col px-0">
                  <label for="email" class="form-label">last Name <span class="text-danger"> *</span></label>
                  <input type="text" name="lname" id="lname" class="input form-control">
                </div>
              </div>
            </div>

            <div class="container">
              <div class="row">
                <div class="col px-0 mr-3">
                  <label for="email" class="form-label">Province <span class="text-danger"> *</span></label>
                  <select name="province" class="input form-control" id="province">
                    <option value="">Select Your Province</option>
                  </select>
                </div>
                <div class="col px-0 mr-3">
                  <label for="email" class="form-label">Municipality <span class="text-danger"> *</span></label>
                  <select name="municipal" class="input form-control" id="municipal">
                    <option value="">Select Your Municapality</option>
                  </select>
                </div>
                <div class="col px-0">
                  <label for="email" class="form-label">Barangy <span class="text-danger"> *</span></label>
                  <select name="barangay" class="input form-control"id="barangay">
                    <Option>Select Barangay</Option>
                  </select>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Contact no. <span class="text-danger"> *</span></label>
              <input type="number" class="input form-control" id="contactNo" name="contactNo" >
            </div>

            <label class="form-label">Login Information</label>
            <hr class="border-dark" style="margin-top: 0;">
            <div class="mb-3">
              <label for="email" class="form-label">Email <span class="text-danger"> *</span></label>
              <input type="text" class="input form-control" id="email" name="email" placeholder="Enter your email">
            </div>
            <div class="container">
              <div class="row">
                <div class="col px-0 mr-3  mb-3 form-password-toggle">
                  <label class="form-label" for="password">Password <span class="text-danger"> *</span></label>
                  <div class="input-group input-group-merge">
                    <input type="password" id="password" class="input form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="col  px-0 mb-3 form-password-toggle">
                  <label class="form-label" for="password">Re-Type Password <span class="text-danger"> *</span></label>
                  <div class="input-group input-group-merge">
                    <input type="password" id="retype-password" class="input form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
              </div>
            </div>
            
            
            <div class="row password-requirements" style ="display:flex;flex-direction:column;display:none;color:grey;padding:.5em;background-color:#f4f4f4;border-radius:6px">
              <span>Password must contain :</span>
              <li id ="capital">at least one capital letter</li>
              <li id ="small">at least one small letter</li>
              <li id ="number">at least one number</li>
              <li id ="eight_char">at least 8 characters</li>
              <li id ="special">at least one special character</li>
          </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                <label class="form-check-label" for="terms-conditions">
                  I agree to
                  <a href="javascript:void(0);">privacy policy & terms</a>
                </label>
              </div>
            </div>
            <button id="Register-btn" class="btn btn-primary d-grid w-100" type="submit">
              Sign up
            </button>
          </form>

          <p class="text-center">
            <span>Already have an account?</span>
            <a href="{{url('login')}}">
              <span>Sign in instead</span>
            </a>
          </p>
        </div>
      </div>
      <!-- Register Card -->
    </div>
  </div>
</div>
@endsection