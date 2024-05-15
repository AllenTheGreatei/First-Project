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