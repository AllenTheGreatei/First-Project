<link rel="stylesheet" href="{{asset('new_css/dashboard.css')}}">
<link rel="stylesheet" href="{{asset('new_css/dropdown.css')}}">
<div class="view_room">
    <div class="box">
         {{-- Edit Modal --}}
    <div class="modal fade" id="editroom" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"role="document">
        <div class="modal-content"  >
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Room Information</h5>
            </div>
            <div class="modal-body">
                <form id="edit-room-form">
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
                                <input type="text" class="form-control input" name="hide" id="img" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row mr-3 pb-1">
                                <label for="" class="form-label">Room Name</label>
                                <input type="text" class="form-control input" id="r_name" name="r_name">
                            </div>
                            <div class="row mr-3 pb-1">
                                <label for="" class="form-label">Price</label>
                                <input type="number" class="form-control input" id="r_price" name="r_price">
                            </div>
                            <div class="row mr-3 pb-1">
                                <label for="" class="form-label">Category</label>
                                <select class="form-control input" id="r_category" name="r_category" >
                                    @if ($categories)
                                        @foreach ($categories as $category)
                                        <option value="{{$category->Name}}">{{ $category->Name}}</option>
                                        @endforeach
                                    @else
                                    <li class="dropdown-item">No Available</li>
                                    @endif
                                </select>
                            </div>
                            <div class="row mr-3 pb-1">
                                <label for="" class="form-label">Facilities</label>

                                <div class="dropdown" id="dropdown">
                                    <input  class="form-control dropdown-toggle" type="text" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" name="r_facility">
                                    <div class="dropdown-menu" id="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @if ($facilities)
                                            @foreach ($facilities as $facility)
                                            <li class="dropdown-item"><span class="check">✔️ </span>{{ $facility->name}}</li>
                                            @endforeach
                                        @else
                                        <li class="dropdown-item">No Available</li>
                                        @endif
                                    </div>
                                </div>
                                  
                            </div>
                            <div class="row mr-3 pb-1">
                                <label for="" class="form-label">Features</label>

                                <div class="dropdown" id="dropdown1">
                                    <input  class="form-control dropdown-toggle" type="text" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" name="r_feature">
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        @if ($features)
                                            @foreach ($features as $feature)
                                                <li class="dropdown-item"><span class="check">✔️ </span>{{ $feature->name}}</li>
                                            @endforeach
                                        @else
                                        <li class="dropdown-item">No Available</li>
                                        @endif
                                    </div>
                                </div>

                                {{-- <select class="form-control" id="r_facilities" name="r_facilities"> --}}
                                    {{-- <option value="Delux">Wifi</option>
                                    <option value="Delux">Bathtub</option> --}}
                                {{-- </select> --}}
                            </div>
                            <div class="row mr-3 pb-1">
                                <div class="col ml-0 px-0 mr-2">
                                    <label for="" class="form-label">Adult</label>
                                    <input type="number" name="r_adult" id="r_adult"class="input form-control">
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
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeeditr">Close</button>
            <button type="button" class="btn btn-primary" id="save_edited_room">Save changes</button>
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
            <tbody id ="table_body" class="room_tbody">
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
                            <td><button class ="update-room-btn" data-toggle="modal" data-target="#editroom" value="{{ $room->id }}"><i class='fa fa-edit mr-1' style='color:#efefeb'></i></button></button><button class ="delete-room-btn" value="{{ $room->id }}">
                                <i class='fa fa-trash mr-1' style='color:#f2f3ed'></i></button></td>
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
<script>
    $(document).ready(function(){
        $('#dropdown .dropdown-menu').on('click','.dropdown-item',function(e){
            e.stopPropagation();
            let text = $(this)
                    .contents() // Get all child nodes, including text nodes and elements
                    .filter(function() {
                        // Filter out any elements with class "check"
                        return this.nodeType === 3 || !$(this).hasClass('check');
                    })
                    .text() // Get the text content
                    .trim(); // Trim leading and trailing whitespace
                            
            // let strippedText = text.replace("✔️ ", "");

            let currentValue = $('#dropdownMenuButton').val();
            if (!currentValue.includes(text)) {
                $(this).addClass('selected');
                $(this).find('.check').css('display', 'block');
                if(!currentValue){
                    $('#dropdownMenuButton').val(text)
                }else{
                    $('#dropdownMenuButton').val(currentValue +", "+ text.trim());
                }
            }
        });

        $('#dropdown .dropdown-menu').on('click', '.selected', function () {
            let text = $(this)
                    .contents() // Get all child nodes, including text nodes and elements
                    .filter(function() {
                        // Filter out any elements with class "check"
                        return this.nodeType === 3 || !$(this).hasClass('check');
                    })
                    .text() // Get the text content
                    .trim(); // Trim leading and trailing whitespace
            // let strippedText = text.replace("✔️ ", "");

            $(this).removeClass('selected');
            $(this).find('.check').css('display', 'none');
            let currentValue = $('#dropdownMenuButton').val();

            if (currentValue.includes(', '+text)) {
                let updatedValue = currentValue.replace(', '+text, "").replace(", ,", ", ").trim();
                $('#dropdownMenuButton').val(updatedValue);
            }else if(currentValue.includes(text+', ')|| currentValue.includes(text+',')){
                let updatedValue = currentValue.replace(text+', ', "").replace(text+',', "").replace(", ,", ", ").trim();
                $('#dropdownMenuButton').val(updatedValue);
            }else if(!currentValue.includes(',')){
                let updatedValue = currentValue.replace(text, "").replace(", ,", ", ").trim();
                $('#dropdownMenuButton').val(updatedValue);
            }
        });

        $('#dropdown1 .dropdown-menu').on('click','.dropdown-item',function(e){
            e.stopPropagation();
             let text = $(this)
                    .contents() // Get all child nodes, including text nodes and elements
                    .filter(function() {
                        // Filter out any elements with class "check"
                        return this.nodeType === 3 || !$(this).hasClass('check');
                    })
                    .text() // Get the text content
                    .trim(); // Trim leading and trailing whitespace

            let currentValue = $('#dropdownMenuButton1').val();
            if (!currentValue.includes(text)) {
                $(this).addClass('selected');
                $(this).find('.check').css('display', 'block');
                if(!currentValue){
                    $('#dropdownMenuButton1').val(text)
                }else{
                    $('#dropdownMenuButton1').val(currentValue +", "+ text);
                }
            }
        });

        $('#dropdown1 .dropdown-menu').on('click', '.selected', function () {
            let text = $(this)
                    .contents() // Get all child nodes, including text nodes and elements
                    .filter(function() {
                        // Filter out any elements with class "check"
                        return this.nodeType === 3 || !$(this).hasClass('check');
                    })
                    .text() // Get the text content
                    .trim(); // Trim leading and trailing whitespace
            $(this).removeClass('selected');
            $(this).find('.check').css('display', 'none');
            let currentValue = $('#dropdownMenuButton1').val();

            if (currentValue.includes(', '+text)) {
                let updatedValue = currentValue.replace(', '+text, "").replace(", ,", ", ").trim();
                $('#dropdownMenuButton1').val(updatedValue);
            }else if(currentValue.includes(text+', ')|| currentValue.includes(text+',')){
                let updatedValue = currentValue.replace(text+', ', "").replace(text+',', "").replace(", ,", ", ").trim();
                $('#dropdownMenuButton1').val(updatedValue);
            }else if(!currentValue.includes(',')){
                let updatedValue = currentValue.replace(text, "").replace(", ,", ", ").trim();
                $('#dropdownMenuButton1').val(updatedValue);
            }
        });
    });
</script>