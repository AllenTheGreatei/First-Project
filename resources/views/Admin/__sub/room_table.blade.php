@if ($rooms)
    @php
        $no=1;
    @endphp
    @foreach ($rooms as $room)
        <tr class="row{{$room->id}}">
            <td>{{ $no++ }}</td>
            <td><img style="height:4em;width:auto;border-radius:4px" src="{{asset('RoomImg/'.$room->image)}}" alt=""></td>
            <td  style="text-transform:capitalize">{{ $room->room_name}}</td>
            <td>{{ $room->price}}</td>
            @if ($room->status == 'available')
            <td style="color:rgb(77, 219, 77);text-transform:capitalize">{{ $room->status}}</td>
            @else
            <td style="color:rgb(243, 34, 34)">{{ $room->status}}</td>
            @endif
            <td><button class ="update-room-btn" data-toggle="modal" data-target="#editroom" value="{{ Crypt::encryptstring($room->id) }}"><i class='fa fa-edit mr-1' style='color:#efefeb'></i></button><button class ="delete-room-btn" value="{{ Crypt::encryptstring($room->id) }}">
                <i class='fa fa-trash mr-1' style='color:#f2f3ed'></i></button></td>
        </tr>
    @endforeach
@else
    <tr class="row'.$id.'">
        <td>No Rooms.</td>
    </tr>
@endif