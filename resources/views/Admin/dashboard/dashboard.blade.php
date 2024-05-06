@include('__partials.commonMaster')

@section('title', 'Home Page')

@section('page-style')
<link rel="stylesheet" href="{{asset('new_css/content.css')}}">
<link rel="stylesheet" href="{{ asset('new_css/dashboard.css') }}">
@endsection

@include('Admin/dashboard.sidebar')
@include('Admin/dashboard.navbar')
@include('Admin/dashboard.content')
@extends('__partials.footer')
<script src="{{ asset('new_js/dash.js')}}"></script>
