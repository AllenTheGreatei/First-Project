<link rel="stylesheet" href="{{asset('new_css/dashboard.css')}}">

<div class="booked-container">
    {{-- Book Now Modal --}}
    <div class="modal fade" id="paybtn" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal"role="document">
        <div class="modal-content"  >
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Payment</h5>
            </div>
            <div class="modal-body px-4">
                <div class="row">
                    <input type="text" hidden id="hiden_id">
                    <label for="" class="form-label">Total Amount : </label>
                    <input type="number" id="amount" class="form-control">
                </div>
                <div class="row">
                    <label for="" class="form-label mt-2">Enter Cash  : </label>
                    <input type="number" id="cash" class="form-control">
                </div>
                <div class="row">
                    <label for="" class="form-label mt-2">Change  : </label>
                    <input type="number" id="change" class="form-control" disabled>
                </div>
                <button type="button" id="pay_now" class="mt-3 btn btn-success">Submit</button>
            </div>
            <div class="modal-footer">
                <button type="button" id="closepay" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
    <div class="top">
        <h4 class="text-primary">Booked List</h4>
    </div>

    <div class="container-body">
        <table class = "user-list-table">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>Name</th>
                    <th>Room</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody id ="table_body" class="room_tbody">
                @php
                    $no = 1;
                @endphp
                @foreach ($booked as $book)
                    <tr class="row{{ $book->id }}">
                        
                        <td>{{ $no++}}</td>
                        @foreach ($users as $user)
                            @if ($book->user_id === $user->id)
                                <td>{{ $user->first_name}} {{ $user->last_name}}</td>
                                @break
                            @endif
                        @endforeach

                        @foreach ($rooms as $room)
                            @if ($book->room_id === $room->id)
                                <td>{{ $room->room_name}}</td>
                                @break
                            @endif
                        @endforeach
                        
                        <td>{{ \Carbon\Carbon::parse($book->check_in)->formatLocalized('%B %d, %Y')}}</td>
                        <td>{{ \Carbon\Carbon::parse($book->check_out)->formatLocalized('%B %d, %Y')}}</td>
                        <td>{{ $book->total_amount}}</td>
                        <td>{{ $book->status}}</td>
                        <td>
                            <button class="pay btn-warning" data-toggle="modal" value="{{Crypt::encryptstring($book->id)}}" data-target="#paybtn" >Pay</button>
                        </td>
                        
                    </tr>
                @endforeach
                    
            </tbody>
        </table>
    </div>
</div>

<script src="{{asset('new_js/booking.js')}}"></script>