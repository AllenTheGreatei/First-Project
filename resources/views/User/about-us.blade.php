@extends('__partials.commonMaster')

@section('title', 'About Us')
<link rel="stylesheet" href="{{ asset('new_css/mybooking.css')}}">

@section('content')
    @include('__partials.nav')
    <div class="s bg-white">
        <div class="about-conatiner w-50 h-100 bg-white p-3 m-auto mt-2">
            <h1 class="text-secondary">About Us</h1>
        </div>
    </div>
    

@endsection