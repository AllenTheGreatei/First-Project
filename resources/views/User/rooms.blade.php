@extends('__partials.commonMaster')

@section('title', 'Rooms')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{ asset('new_css/style.css') }}">
@endsection


@section('content')
    @include('__partials.nav')
    <div class="body">
        {{-- Book Now Modal --}}
    <div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"role="document">
        <div class="modal-content"  >
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Book Now</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            ...
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </div>
    </div>
       {{-- More Details Modal --}}
       <div class="modal fade" id="moredetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">More Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            ...
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </div>
    </div>
    <h1 class="headings">OUR ROOMS</h1>
        <div class="divider">
            <div class="left">
                <h5>FILTERS</h5>
                <div class="filter-wrapper">
                    <h6>CHECK AVAILABILITY</h6>
                    <span>Check-in</span>
                    <input type="date" class="form-control">
                    <span>Check-out</span>
                    <input type="date" class="form-control">
                </div>
                <div class="filter-wrapper">
                    <h6>SERVICES</h6>
                    <div class="roww">
                        <input type="checkbox">
                        <span>Wifi</span>
                    </div>
                    <div class="roww">
                        <input type="checkbox">
                        <span>Air conditioner</span>
                    </div>
                    <div class="roww">
                        <input type="checkbox">
                        <span>Televesion</span>
                    </div>
                    <div class="roww">
                        <input type="checkbox">
                        <span>Spa</span>
                    </div>
                    <div class="roww">
                        <input type="checkbox">
                        <span>Room Heater</span>
                    </div>
                </div>
                <div class="filter-wrapper">
                    <h6>Guest</h6>
                    <div class="roww" style="justify-content:space-around">
                        <span>Adult</span>
                        <span>Kids</span>
                    </div>
                    <div class="roww">
                        <input type="text" class="form-control">
                        <input type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="right1">
                @if ($rooms)
                    @foreach ($rooms as $room)
                    <div class="right" style="height: 21em">
                        <div class="room-pic">
                            <img class="list" src="{{asset('RoomImg/'.$room->image)}}" alt="">
                        </div>
                        <div class="room-info">
                            <h5>{{ $room->room_name}}</h5>
                            <h6>Features</h6>
                            <span>{{ $room->room_features}}</span>
                            <h6>Facilities</h6>
                            <span>{{ $room->room_facilities}} </span>
                            <h6>Guest</h6>
                            <span>{{ $room->adult}} Adults / 
                                @if ($room->children)
                                    {{ $room->children}}
                                @else
                                    {{ '0' }}
                                @endif 
                                Children </span>
                            <h6>Room Price</h6>
                            <span>₱ {{$room->price}} per night</span>
                        </div>
                        <div class="room-btn">
                                <button type="button"class="btn btn-success" data-toggle="modal" data-target="#bookModal">Book Now</button>
                                <button type="button"class="more" data-toggle="modal" data-target="#moredetailsModal">More Details</button>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            
        </div>
        
        {{-- <div class="room-list">
            <div class="card">
                
            </div>
        </div> --}}
    </div>
    
    
@endsection