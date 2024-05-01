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
      <div class="card">
        <div class="card-body">
          <div class="mb-3 p-3">
            <label for="email" class="form-label fs-4 mb-4">OTP VERIFICATION</label>
            <label for="email" class="form-label fs-7 mb-4">PLEASE ENTER 6 DIGIT OTP CODE WE SENT TO <span class="text-normal">{{session('email')}}</span></label>
            
            <input type="number" style="text-align:center;font-size:2em;" class="otp-input form-control mb-4" id="otp" name="otp-input">
            <button id="otp-submit" class="btn btn-primary d-grid w-100" type="button">
              Submit
            </button>
          </div>
        </div>
      </div>
      <!-- Register Card -->
    </div>
  </div>
</div>
@endsection