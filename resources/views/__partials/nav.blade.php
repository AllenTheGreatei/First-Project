<meta name="csrf-token" content="{{ csrf_token() }}">
@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{ asset('new_css/style.css') }}">
@endsection

<div class="nav">
    <div class="logo">
        <img src="{{ asset('assets/img/logo.png') }}" alt="logo">
        <h3 class="font-sans">Hotel Booking</h3>
    </div>

    <div class="nav-nav">
        <li class="nav-btn active"><a class="a active1" href="/home">Home</a></li >
        <li class="nav-btn"><a class="a" href="/rooms">Rooms</a></li >
        <li class="nav-btn"><a class="a"href="#">Hotel Info</a></li >
        <li class="nav-btn"><a class="a"href="#">Contact Us</a></li >
        <li class="nav-btn"><a class="a"href="#">About Us</a></li >
        @if (session('username')  && auth()->user() && auth()->user()->hasVerifiedEmail())
            <li class="nav-btn"><a class="a"href="#">My Bookings</a></li >
        @endif
    </div>

    <div class="nav-nav-nav">
        @if (session('username')  && auth()->user() && auth()->user()->hasVerifiedEmail() )
            <h4 class="user_name signin" style="margin-top: .2em"><a href="/login">{{ session('username')}}</a></h4>
            <div class="profile-box">
                <div class="prof">
                    <img id="user-prof" src="{{asset('assets/img/avatars/1.png')}}" alt="">
                    <span>{{session('username')}}</span>
                </div>
                <hr style="margin:.4em">
                <button id="profile-btn">Profile</button>
                <hr style="margin:.4em">
                <button id="logout" style="margin-bottom: .5em">Logout</button>
            </div>
            <i class="far fa-user" style="font-size:1.5em"></i> 
        @else
            <h4 class="register" style="border: 1px solid black;border-radius:15px;padding:.2em 1em; margin-right:2em;"><a href="/register">Join Us</a></h4>
            <h4 class="signin" style="margin-top: .2em"><a href="/login">Sign in</a></h4>
            <i class="far fa-user" style="font-size:1.5em"></i> 
        @endif
        
    </div>
</div>
@extends('__partials.footer')