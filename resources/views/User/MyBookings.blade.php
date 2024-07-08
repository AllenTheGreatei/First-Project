@extends('__partials.commonMaster')

@section('title', 'My Bookings')
<link rel="stylesheet" href="{{ asset('new_css/mybooking.css')}}">
@section('content')

    @include('__partials.nav')

    <div class="modal fade" id="cancelbooking" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal"role="document">
        <div class="modal-content"  >
            <form id="cancel-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Cancel Booking ?</h5>
                </div>
                <div class="modal-body">
                    <span class="mt-4 text-info font-italic">Info : Booking cancellation required admin approval!</span>
                    <label class="form-label fs-6 ">Reason of Cancellation : </label>
                    <textarea id="reason" rows="6" cols="50" class="input form-control"></textarea>
                    <input type="text" hidden id="idhold">
                </div>
                <div class="modal-footer">
                    <button type="button" id="c" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="cancel" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
        </div>
    </div>


    <div class="mybooking-container">
        @if (session('paid'))
       
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Room was Booked Successfully!',
                    showConfirmButton: true,
                    confirmButtonText: 'Okay'
                });
            </script>

        @endif
        <div class="book-head mt-3 bg-white p-3">
            <h5 class="text-primary ml-3 mt-1">My Bookings</h5>
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

                            <label class="form-label">Status : 
                                @if ($data->status == 'Paid' || $data->status == 'Checked Out')
                                    @if ($data->check_in >= now())
                                        <span style="color:rgb(21, 236, 21)">Ongoing</span>

                                    @else
                                        @if ($data->check_out < now())
                                            <span style="color:rgb(21, 236, 21)">{{$data->status}}</span>
                                        @else
                                            <span style="color:rgb(21, 236, 21)">In</span>
                                        @endif
                                        
                                    @endif
                                @else
                                    <span style="color:rgb(233, 40, 15)">{{ $data->status}}</span>  
                                @endif    
                            </label><br>
                            @if ($data->created_at != $data->updated_at)
                            {{-- <label class="form-label">Paid At : {{ \Carbon\Carbon::parse($data->updated_at)->formatLocalized('%B %d, %Y %H:%M:%S') }}</label><br> --}}
                                
                            @endif
                            <label class="form-label">Total Amount : {{ number_format($data->total_amount, 2); }}</label><br>
                            {{-- <label class="form-label">Cash : {{ $data->cash }}</label><br> --}}
                            {{-- <label class="form-label">Change :status != "Cancelled" {{ $data->change }}</label><br> --}}
                            @if ($data->check_in > now() && $data->status != "Cancelled" && $data->status != "Requested Cancellation")
                                <button class="btn btn-warning px-4 cancel-show" data-toggle="modal" data-target="#cancelbooking" style="margin-top:8em;" value="{{ $data->id }}">Cancel Booking</button>
                            @endif
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
    <script src="{{asset('new_js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('new_js/booking.js')}}"></script>
@endsection
