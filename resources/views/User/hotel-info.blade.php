@extends('__partials.commonMaster')

@section('title', 'Hotel Info')
<link rel="stylesheet" href="{{ asset('new_css/mybooking.css')}}">


@section('content')
    @include('__partials.nav')
    <div class="s bg-white"> 
        <div class="info-conatiner w-50 h-100 bg-white p-3 m-auto mt-2">
            <h1 class="text-secondary">Hotel Booking</h1>
        </div>
    </div>
    

@endsection