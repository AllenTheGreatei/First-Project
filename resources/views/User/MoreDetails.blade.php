@extends('__partials.commonMaster')

@section('title', 'More Details')

@section('content')
    @include('__partials.nav')
    <div class="main-container">
        <div class="head">
            {{-- <i class='fa fa-arrow-left arrow'></i> --}}
            <img src="{{asset('RoomImg/'.$room->image)}}" alt="">
            {{-- <i class='fa fa-arrow-right arrow'></i> --}}
        </div>
        <div class="body">
            <div class="row">
                <div class="col">
                    <h3 class="text-primary">{{ $room->room_name}}</h3>
                </div>
                <div class="col">
                    <h3 style="width: 100%;padding-right:1em;text-align:right;color:darkgrey">₱ {{ $room->price}} /per night</h3>
                </div>
            </div>
            <h5 style="color:rgb(82, 82, 82)"> Room Type : {{ $room->room_category}}</h5>
            <div class="row">
                <h5 class="text-primary mt-4">Description</h5>
                <p>{{ $room->description}}.</p>
            </div>

            <div class="row">
                <h5 class="text-primary mt-4">Aminities</h5>
                <div class="aminities">
                    @foreach ($aminities as $aminity)
                        <label for="" class="form-label"><i class='fa fa-check-square'></i> {{ $aminity }}</label>
                    @endforeach
                </div>
            </div>

            <div class="row">
                <h5 class="text-primary mt-4">Feature</h5>
                <div class="feature">
                    @foreach ($features as $feature)
                    <label for="" class="form-label"><i class='fa fa-check-square'></i> {{$feature }}</label>
                    @endforeach
                </div>
            </div>

            <div class="row">
                <h5 class="text-primary mt-4">Guest</h5>
                <div class="feature">
                    <label for=""><i class='fa fa-check-square'></i> Can Accomodate up to {{$room->adult}} Adults and {{$room->children}} Childrens</label>
                </div>
            </div>

            
        </div>
    </div>
@endsection
