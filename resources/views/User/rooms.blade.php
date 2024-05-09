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
                </div>
                <div class="modal-body">
                    @if (session('username')  && auth()->user() && auth()->user()->hasVerifiedEmail())
                        <div class="main">
                            <div>
                                <img id="r_img"style="height: 16em;width:auto" alt="">
                                <input type="text" hidden id="idholder">
                                <input type="text" id="notice" hidden>
                            </div>
                            <div class="pl-4 w-100">
                                <h3 class="text-primary mb-1" id="room_n"></h3>
                                <h6 class="form-label text-secondary mb-4" style="font-size:1em " id="room_p"></h6>
                                <labal class="form-label">Check In</labal>
                                <input id="start_date" type="date" name="" class="mb-3 form-control date">
                                <input type="number" id="real_price" hidden>
                                <labal  class="form-label">Check Out</labal>
                                <input id="end_date" type="date" name="" class="form-control date" id="">

                                <h6 class="mt-4"><span></span>Total Day(s) : <span  id="days"></span></h6>
                                <h6 class="mt-2"><span></span>Total Amount to be paid : <span  id="total_p">0</span></h6>
                                <input type="number" id="real_total" hidden>
                            </div>
                            
                        </div>
                        <div class="row notavailable">
                            <label for="" class="form-label text-danger">Not Available date :</label>
                            <div class="notavialablelist">
                                
                            </div>
                        </div>
                    @else
                        <h1 class="text-center display-4" style="font-weight: 500">Login First</h1>
                    @endif
                </div>
                <div class="modal-footer">
                    @if (session('username')  && auth()->user() && auth()->user()->hasVerifiedEmail())
                        <button type="button" id="closebook" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="book_now" class="btn btn-success">Book Now</button>
                    @else
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Okay</button>
                    @endif
                
                </div>
            </div>
            </div>
        </div>


    <h1 class="headings">OUR ROOMS</h1>
        <div class="divider">
            <div class="left">
                <h5>FILTERS</h5>
                <i class='fa fa-refresh' id="refresh"></i>
                {{-- CHECK AVAILABILITY --}}
                <div class="filter-wrapper">
                    <h6>CHECK AVAILABILITY</h6>
                    <span>Check-in</span>
                    <input type="date" id="fromdate" class="form-control">
                    <span>Check-out</span>
                    <input type="date" id="enddate" class="form-control">
                </div>
                <div class="filter-wrapper">
                    <h6>Room Type</h6>
                    <select name="" id="Scategory" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{$category->Name}}"> {{$category->Name}}</option>
                        @endforeach
                    </select>

                </div>
                <div class="filter-wrapper">
                    <h6>Guest</h6>
                    <div class="roww" style="justify-content:space-around">
                        <span>Adult</span>
                        <span>Kids</span>
                    </div>
                    <div class="roww">
                        <input type="number" id="Sadult" class="form-control">
                        <input type="number" id="Schildren" class="form-control">
                    </div>
                </div>
                {{-- Filter Aminities --}}
                <div class="filter-wrapper">
                    <h6>Aminities</h6>
                    @foreach ($aminities as $aminity)
                    <div class="roww">
                        <input type="checkbox" class="Saminities select" value="{{ $aminity->name }}">
                        <span> {{$aminity->name}}</span>
                    </div>
                    @endforeach
                    
                </div>

                


               
            </div>
            <div class="right1">
                @if ($rooms)
                    @foreach ($rooms as $room)
                    <div class="right" >
                        <div class="room-pic">
                            <img class="list" src="{{asset('RoomImg/'.$room->image)}}" alt="">
                        </div>
                        <div class="room-info">
                            <h5>{{ $room->room_name}} </h5>
                            <h6>Features</h6>
                                @php
                                    $feature = $room->room_features;
                                    $featuresArray = explode(',', $feature);
                                    $cutFeatures = implode(',', array_slice($featuresArray, 0, 3));
                                @endphp
                                <p class="roow-f">{{ $cutFeatures}} ...</p>
                            <h6>Aminities</h6>
                                @php
                                    $facility = $room->room_facilities;
                                    $facilityArray = explode(',', $facility);
                                    $cutFacility = implode(',', array_slice($facilityArray, 0, 3));
                                @endphp
                                <span class="room-aminities"> {{ $cutFacility}}... </span>
                            <h6>Guest</h6>
                            <span>{{ $room->adult }}  Adults / 
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
                                <button type="button"class="btn btn-success show-book" data-toggle="modal" data-target="#bookModal" value="{{Crypt::encryptstring($room->id)}}">Book Now</button>
                                <button type="button"class="more"><a href="{{ route('moredetails', [$room->id]) }}" style="text-decoration:none;color:black">More Details</a></button>
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
    <script src="{{asset('new_js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('new_js/booking.js')}}"></script>
    <script>
        $(document).ready(function(){

            var currentDate = new Date();
            var currentDateString = currentDate.toISOString().split('T')[0];

            $('#start_date, #end_date').attr('min', currentDateString);
            $('#fromdate, #enddate').attr('min', currentDateString);

            $('#start_date').change(function() {

            var startDate = new Date($(this).val());

            startDate.setDate(startDate.getDate() + 1);

            var endMinDate = startDate.toISOString().split('T')[0];

            $('#end_date').attr('min', endMinDate);
            $('#days').text('0');
            $('#end_date').val('');
            $('#total_p').html('0')
            });

            $('#end_date').change(function() {
                var startDateValue = $('#start_date').val();
                var endDateValue = $('#end_date').val();

                var startDate = new Date(startDateValue);
                var endDate = new Date(endDateValue);

                var differenceInTime = endDate.getTime() - startDate.getTime();
                var differenceInDays = Math.ceil(differenceInTime / (1000 * 3600 * 24));

                $('#days').text(differenceInDays);

                let total = differenceInDays * $('#real_price').val();

                $('#real_total').val(total);
                $('#total_p').html('₱ ' +total.toLocaleString('en-US'));
            });


            $('#fromdate').change(function() {
            var startDate = new Date($(this).val());

            startDate.setDate(startDate.getDate() + 1);

            var endMinDate = startDate.toISOString().split('T')[0];

            $('#enddate').attr('min', endMinDate);
            $('#enddate').val('');
            });

            $('#enddate').change(function() {
                var startDateValue = $('#fromdate').val();
                var endDateValue = $('#enddate').val();

                var startDate = new Date(startDateValue);
                var endDate = new Date(endDateValue);

                var differenceInTime = endDate.getTime() - startDate.getTime();
                var differenceInDays = Math.ceil(differenceInTime / (1000 * 3600 * 24));
            });
            
        });
        
    </script>
@endsection