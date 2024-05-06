<div class="facility-container">
    {{-- add modal --}}
    <div class="modal fade" id="add_facility" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal"role="document">
        <div class="modal-content"  >
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add New Facility</h5>
            </div>
            <div class="modal-body">
                <form action="add_category_form">
                    <div class="form-group">
                        <label class="form-label">New Facility</label>
                        <input type="text" id="facility_name" name ="facility_name" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="fclose" >Close</button>
            <button type="button" class="btn btn-primary" id="save_facility">Save</button>
            </div>
        </div>
        </div>
    </div>
    {{-- edit modal --}}
    <div class="modal fade" id="update_facility" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal"role="document">
        <div class="modal-content"  >
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Facility</h5>
            </div>
            <div class="modal-body">
                <form action="add_category_form">
                    <div class="form-group">
                        <label class="form-label">Facility</label>
                        <input type="text" hidden id="id_hidden">
                        <input type="text" id="edit_facility_name" name ="edit_facility_name" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="facilityclose" >Close</button>
            <button type="button" class="btn btn-primary" id="save_edit_facility">Save</button>
            </div>
        </div>
        </div>
    </div>
    <div class="box">
        <h4 style="color:#787bff;font-size:1.5em;font-weight:600">Room Facility</h4>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_facility">Add New Facility</button>
    </div>
    <div class="table">
        <table class = "user-list-table">
            <thead>
                <tr>
                    <th style="color:white;font-size:1em">NO.</th>
                    <th style="color:white;font-size:1em">Name</th>
                    <th style="color:white;font-size:1em">Action</th>
                </tr>
            </thead>
            <tbody id ="table_body" class="tb_facility">
                @if ($facilities)
                @php
                    $no = 1;
                @endphp
                    @foreach ($facilities as $facility)
                        <tr class="row{{$facility->id}}">
                            <td>{{ $no++ }}</td>
                            <td>{{ $facility->name}}</td>
                            <td><button class ="update-facility-btn" data-toggle="modal" data-target="#update_facility" value="{{ Crypt::encryptstring($facility->id) }}"><i class='fa fa-edit mr-1' style='color:#efefeb'></i></button>
                                <button class ="delete-facility-btn" value="{{ Crypt::encryptstring($facility->id) }}"><i class='fa fa-trash mr-1' style='color:#f2f3ed'></i></button></td>
                        </tr>
                    @endforeach
                    <button id="num" value="{{ $no }}" hidden></button>
                @else
                <tr>
                    <td>No Facility Available</td>
                @endif
                
            </tbody>
        </table>
    </div>
</div>
<script src="{{asset('new_js/roomCrud.js')}}"></script>