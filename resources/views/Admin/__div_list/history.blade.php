<div class="history-container bg-white p-4 rounded">
    <div class="head p-3">
        <h4 class="text-primary">Check Out History</h4>
    </div>
    <div class="body">
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
                            @if ($book->status == 'Checked Out')
                                <td style="color:rgb(5, 255, 47)">{{$book->status}}</td>
                            @else
                                <td style="color:rgb(255, 43, 5)">{{$book->status}}</td>
                            @endif
                        </tr>
                    @endforeach
                @else
                    <td>No Bookings.</td>
                @endif
            </tbody>
        </table>
    </div>
</div>