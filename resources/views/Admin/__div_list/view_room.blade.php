<link rel="stylesheet" href="{{asset('new_css/dashboard.css')}}">
<div class="view_room">
    <div class="box">
         {{-- Book Now Modal --}}
    <div class="modal fade" id="editroom" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"role="document">
        <div class="modal-content"  >
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Book Now</h5>
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
    {{-- Table --}}
        <table class = "user-list-table">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody id ="table_body">
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
                            <td><button class ="update-room-btn" data-toggle="modal" data-target="#editroom" value="{{ $room->id }}">EDIT</button><button class ="delete-room-btn" value="{{ $room->id }}">DELETE</button></td>
                        </tr>
                    @endforeach
                @else
                    <tr class="row'.$id.'">
                        <td>No Rooms.</td>
                    </tr>
                @endif
                
            </tbody>
        </table>
    </div>
</div>
<script src="{{asset('new_js/roomCrud.js')}}"></script>