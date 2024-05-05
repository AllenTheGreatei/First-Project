<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/css/multi-select-tag.css">
<div class="div add">
    <h5>ADD NEW ROOM</h5>
    <div class="wrap">
        <label for="" style="color:red">* Indicates required fields</label>
    <form id="addRoomForm" method="POST" enctype="multipart/form-data">
        
        <div class="row">
            <div class="col">
                <div class="rows">
                    <label for="roomName">Room Name <span style="color:red"> *</span></label>
                    <input type="text" name="roomName" id="roomName" class="input form-control">
                </div>
            </div>
            <div class="col">
                <div class="rows">
                    <label for="roomName">Price<span style="color:red"> *</span></label>
                    <input type="number" name="price" id="price" class="input form-control">
                </div>
            </div>
        </div>
        
        
        <div class="row">
            <div class="col">
                <div class="rows">
                    <label for="roomName">Features<span style="color:red"> *</span></label>
                    <select class=""name="features" id="features">
                        @if ($features)
                            @foreach ($features as $feature)
                                <option value="{{ $feature->name }}">{{ $feature->name }}</option>
                            @endforeach
                        @else
                            <option">No Available feature</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="rows">
                    <label for="roomName">Facilities<span style="color:red"> *</span></label>
                    <select class=""name="facilities" id="facilities">
                        @if ($facilities)
                            @foreach ($facilities as $facility)
                                <option value="{{ $facility->name }}">{{ $facility->name }}</option>
                            @endforeach
                        @else
                            <option">No Available facility</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
        

        <div class="row">
            <div class="col">
                <label for="roomName">Adult<span style="color:red">*</span></label>
                <input type="number" name="adult" id="adult" class="form-control">
            </div>
            <div class="col">
                <label for="roomName">Children</label>
                <input type="number" name="children" id="children" class="form-control">
            </div>
        </div>
        
        <div class="rows">
            <label for="roomName">Category<span style="color:red"> *</span></label>
            <select class="form-control" name="category" id="category">
                @if ($categories)
                    @foreach ($categories as $category)
                        <option value="{{ $category->Name }}">{{ $category->Name }}</option>
                    @endforeach
                @else
                    <option">No Available category</option>
                @endif
            </select>
        </div>

        <div class="rows">
            <label for="description">Description<span style="color:red"> *</span></label>
            <textarea id="description" name="description" rows="4" cols="50" class="input form-control"></textarea>
        </div>

        <div class="rows">
            <label for="room_img">Room Main Picture<span style="color:red"> *</span></label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="uploadImg"  name="image">
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
            <input type="text" class="form-control" id="img" hidden="hidden" disabled>
        </div>

        <div class="rows">
            <button type="submit"class="btn btn-primary" id="addBtn">Add New Room</button>
        </div>
    </form>
    </div>
</div>
{{-- <script src="{{asset('new_js/content.js')}}"></script> --}}
<script src="{{asset('new_js/dashboard_script.js')}}"></script>
{{-- @extends('__partials.footer') --}}
<script>
    $('.browse').click(function () {
        $('#uploadImg').click();
    });
    $('.custom-file').on('change', '#uploadImg', function () {
        var file = this.files[0];
        $('#img').val(file.name);
        $('#img').prop('hidden', false);
    });
    function warning_msg(msg) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-right',
        iconColor: 'white',
        customClass: {
        popup: 'colored-toast'
        },
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true
    });
    Toast.fire({
        icon: 'warning',
        title: msg
    });
    }
    function success_msg(msg) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-right',
        iconColor: 'white',
        customClass: {
        popup: 'colored-toast'
        },
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true
    });
    Toast.fire({
        icon: 'success',
        title: msg
    });
    }
    function error_msg(msg) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-right',
        iconColor: 'white',
        customClass: {
        popup: 'colored-toast'
        },
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true
    });
    Toast.fire({
        icon: 'error',
        title: msg
    });
    }
    if (typeof featuresList === 'undefined') {
    var featuresList = [];
    }

    if (typeof facilityList === 'undefined') {
    var facilityList = [];
    }

    new MultiSelectTag('features', {
    rounded: true,
    onChange: function (values) {
        featuresList = [];
        let i = 0;
        values.forEach(value => {
        featuresList.push(values[i].value);
        i++;
        });
    }
    });

    new MultiSelectTag('facilities', {
    rounded: true,
    onChange: function (values) {
        facilityList = [];
        let i = 0;
        values.forEach(value => {
        facilityList.push(values[i].value);
        i++;
        });
    }
    });
    $(document).ready(function () {
    if (featuresList.length == 0) {
        featuresList.push($('#features').val());
    }
    if (facilityList.length == 0) {
        facilityList.push($('#facilities').val());
    }

    $('#addRoomForm').submit(function (e) {
        e.preventDefault();

        const new_room = {
        room_features: featuresList,
        room_facility: facilityList
        };
        let formData = new FormData($('#addRoomForm')[0]);
        formData.append('new_room[room_features]', new_room.room_features);
        formData.append('new_room[room_facility]', new_room.room_facility);

        let check = true;
        let roomName = $('#roomName').val();
        let price = $('#price').val();
        let adult = $('#adult').val();
        let description = $('#description').val();

        if (!roomName || !price || !adult || !description) {
        warning_msg('Fill all required fields.');
        check = false;
        }
        if (check) {
        if (!$('#uploadImg').val()) {
            warning_msg('Room image is required.');
            $('.browse').css('border-color', 'red');
        } else {
            $('.browse').css('border-color', 'blue');
            $.ajax({
            url: 'addNewRoom',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $('#addBtn').prop('disabled', true);
                $('#addBtn').html('Adding...');
            },
            success: function (data) {
                if (data.message == 'success') {
                    success_msg('New Room Added Successfully.');
                    $('#roomName').val('');
                    $('#price').val('');
                    $('#adult').val('');
                    $('#description').val('');
                    $('.rows #img').prop('hidden', true);
                } else if (data.message == 'failed') {
                    error_msg('Opps! Something went wrong.');
                } else {
                    error_msg('Invalid Image.');
                }
                $('#addBtn').prop('disabled', false);
                $('#addBtn').html('Add New Room');
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
                error_msg('Opps! Something went wrong.');
                $('#addBtn').prop('disabled', false);
                $('#addBtn').html('Add New Room');
            }
            });
        }
        }
    });
    });

    
  
        
</script>