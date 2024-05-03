<link rel="stylesheet" href="{{asset('new_css/dashboard.css')}}">
<div class="view_room">
    <div class="box">
         {{-- Book Now Modal --}}
    <div class="modal fade" id="editroom" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"role="document">
        <div class="modal-content"  >
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Room Information</h5>
            </div>
            <div class="modal-body">
                <form action="" class="edit-room-form">
                    <div class="row">
                        <div class="col px-5">
                            <div class="row">
                                <img style="height:18em;width:auto;" id="room-image">
                            </div>
                            <div class="row mt-2">
                                <label for="room_img">Room Main Picture<span style="color:red"> *</span></label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="uploadImg"  name="image">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                <input type="text" class="form-control" id="img" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row mr-3 pb-1">
                                <label for="" class="form-label">Room Name</label>
                                <input type="text" class="form-control" id="r_name" name="r_name">
                            </div>
                            <div class="row mr-3 pb-1">
                                <label for="" class="form-label">Price</label>
                                <input type="number" class="form-control" id="r_price" name="r_price">
                            </div>
                            <div class="row mr-3 pb-1">
                                <label for="" class="form-label">Category</label>
                                <select class="form-control" id="r_category" name="r_category" >
                                    <option value="Delux">asd</option>
                                    <option value="Delux">rtw</option>
                                </select>
                            </div>
                            <div class="row mr-3 pb-1">
                                <label for="" class="form-label">Features</label>
                                {{-- <select class="form-control" id="r_features" name="r_feartures"> --}}
                                    {{-- <option value="Delux">Balcony</option>
                                    <option value="Delux">Kitchen</option> --}}
                                {{-- </select> --}}
                                <select class="form-select" multiple aria-label="Multiple select example">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                  
                            </div>
                            <div class="row mr-3 pb-1">
                                <label for="" class="form-label">Facilities</label>
                                <select class="form-control" id="r_facilities" name="r_facilities">
                                    {{-- <option value="Delux">Wifi</option>
                                    <option value="Delux">Bathtub</option> --}}
                                </select>
                            </div>

                            <div class="row mr-3 pb-1">
                                <div class="col ml-0 px-0 mr-2">
                                    <label for="" class="form-label">Adult</label>
                                    <input type="number" name="r_adult" id="r_adult"class="form-control">
                                </div>
                                <div class="col mx-0 px-0">
                                    <label for="" class="form-label">Children</label>
                                    <input type="number" name="r_children" id="r_children"class="form-control">
                                </div>
                                
                            </div>

                            
                        </div>
                        
                    </div>
                    <div class="row ml-3 mr-3 pb-1">
                        <label for="" class="form-label">Description</label>
                        <textarea id="r_description" name="r_description" rows="4" cols="50" class="input form-control"></textarea>
                    </div>
                </form>
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
<script src="{{asset('new_js/content.js')}}"></script>