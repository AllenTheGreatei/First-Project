<link rel="stylesheet" href="{{asset('new_css/dashboard.css')}}">

<div class="booked-container bg-white p-3 rounded">
    <div class="modal fade" id="show-reason" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal"role="document">
        <div class="modal-content"  >
            <form id="cancel-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Reason of Cancellation </h5>
                </div>
                <div class="modal-body">
                    <textarea id="reason2" rows="8" cols="50" class="input form-control"></textarea>
                    <input type="text" hidden id="idhold2">
                </div>
                <div class="modal-footer">
                    <button type="button" id="c" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button type="submit" id="reject" class="btn btn-danger">Reject</button> --}}
                    <button type="submit" id="cancelreal" class="btn btn-success">Cancel Book</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <div class="top d-flex flex-md-row justify-content-between">
        <h4 class="text-primary mt-4">Booked List</h4>
        {{-- <div class="form-control w-25 mr-4">
            Search
            <input type="text" class="form-control" id="search">
        </div> --}}
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
                @if (count($booked) != 0 )
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
                            <td>{{ number_format($book->total_amount, 2);}}</td>
                            {{-- <td style="color:rgb(21, 236, 21)">
                                {{ $book->status}}</td>
                            <td> --}}
                            
                                @if ($book->status == 'Paid')
                                    @if ($book->check_in >= now())
                                        <td style="color:rgb(21, 236, 21)">Ongoing</td>
                                        <td>
                                            <button class="btn-warning can" data-toggle="modal" value="{{Crypt::encryptstring($book->id)}}" data-target="#checkout" >Cancel</button>
                                        </td>

                                    @else
                                        <td style="color:rgb(21, 236, 21)">In</td>
                                        <td>
                                            <button class="btn-info out" data-toggle="modal" value="{{Crypt::encryptstring($book->id)}}" data-target="#checkout" >Checkout</button>
                                        </td>
                                        
                                    @endif
                                    
                                @elseif ($book->status == 'Cancelled')
                                    <td style="color:rgb(192, 8, 8)">
                                        {{ $book->status}}</td>
                                    <td>
                                        <button class="btn-danger" disabled>Cancelled</button>
                                @else
                                    <td style="color:rgb(245, 90, 18)">
                                        {{ $book->status}}</td>
                                    <td>
                                        <button class="btn-warning view-reason" value="{{$book->id}}" data-toggle="modal" data-target="#show-reason">View Reason</button>
                                @endif
                            </td>
                            
                        </tr>
                    @endforeach
                @else
                    <td>No Bookings.</td>
                @endif
                
                    
            </tbody>
        </table>
    </div>
</div>

<script src="{{asset('new_js/booking.js')}}"></script>