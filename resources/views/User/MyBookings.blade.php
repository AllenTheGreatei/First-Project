@extends('__partials.commonMaster')

@section('title', 'More Details')
<link rel="stylesheet" href="{{ asset('new_css/mybooking.css')}}">
@section('content')

    @include('__partials.nav')

    <div class="mybooking-container">
        <div class="book-head mt-3 bg-white p-3">
            <h5 class="text-primary ml-3 mt-1">Booked Room</h5>
        </div>
        <div class="booked">
            @if ($transaction)
                @foreach ($transaction as $data)
                    <div class="user-booked-list">
                        @foreach ($rooms as $room)
                            @if ($room->id === $data->room_id)
                                <img src="{{asset('RoomImg/'.$room->image)}}" alt="">
                                @break
                            @endif
                        @endforeach
                        <div class="left">
                            @foreach ($rooms as $room)
                                @if ($room->id === $data->room_id)
                                <h4>{{ $room->room_name}}</h4>
                                    @break
                                @endif
                            @endforeach
                            
                            <label class="form-label mt-3">Check In : {{ \Carbon\Carbon::parse($data->check_in)->formatLocalized('%B %d, %Y') }}</label><br>
                            <label class="form-label">Check Out : {{ \Carbon\Carbon::parse($data->check_out)->formatLocalized('%B %d, %Y ') }}</label><br>
                            <label class="form-label">Booked At : {{ \Carbon\Carbon::parse($data->created_at)->formatLocalized('%B %d, %Y ') }}</label><br>

                            <label class="form-label">Status : {{ $data->status }}</label><br>
                            @if ($data->created_at != $data->updated_at)
                            <label class="form-label">Paid At : {{ \Carbon\Carbon::parse($data->updated_at)->formatLocalized('%B %d, %Y %H:%M:%S') }}</label><br>
                                
                            @endif
                            <label class="form-label">Total Amount : {{ $data->total_amount }}</label><br>
                            <label class="form-label">Cash : {{ $data->cash }}</label><br>
                            <label class="form-label">Change : {{ $data->change }}</label><br>
                        </div>
                    </div>
                @endforeach
            @else
            <div class="user-booked-list">
                <h6 class="text-primary ml-3 mt-1">No Records Yet</h6>
            </div>
            @endif
             


        </div>
    </div>
@endsection
