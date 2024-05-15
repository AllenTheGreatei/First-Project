<div class="faeture-container bg-white p-4 rounded">
    {{-- add modal --}}
    <div class="modal fade" id="add_feature" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal"role="document">
        <div class="modal-content"  >
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add New Feature</h5>
            </div>
            <div class="modal-body">
                <form action="add_feature_form">
                    <div class="form-group">
                        <label class="form-label">New Feature</label>
                        <input type="text" id="feature_name" name ="feature_name" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="fclose" >Close</button>
            <button type="button" class="btn btn-primary" id="save_feature">Save</button>
            </div>
        </div>
        </div>
    </div>
    {{-- edit modal --}}
    <div class="modal fade" id="update_feature" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal"role="document">
        <div class="modal-content"  >
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Feature</h5>
            </div>
            <div class="modal-body">
                <form action="add_feature_form">
                    <div class="form-group">
                        <label class="form-label">Feature</label>
                        <input type="text" hidden id="id_hidden">
                        <input type="text" id="edit_feature_name" name ="edit_feature_name" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="fetclose" >Close</button>
            <button type="button" class="btn btn-primary" id="save_edit_feature">Save</button>
            </div>
        </div>
        </div>
    </div>
    <div class="box">
        <h4 style="color:#787bff;font-size:1.5em;font-weight:600">Room Features</h4>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_feature">Add New Feature</button>
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
            <tbody id ="table_body" class="tb_feature">
                @if ($features)
                @php
                    $no = 1;
                @endphp
                    @foreach ($features as $feature)
                        <tr class="row{{$feature->id}}">
                            <td>{{ $no++ }}</td>
                            <td>{{ $feature->name}}</td>
                            <td><button class ="update-feature-btn" data-toggle="modal" data-target="#update_feature" value="{{ Crypt::encryptstring($feature->id)}}"><i class='fa fa-edit mr-1' style='color:#efefeb'></i></button>
                                <button class ="delete-feature-btn" value="{{ Crypt::encryptstring($feature->id)}}"><i class='fa fa-trash mr-1' style='color:#f2f3ed'></i></button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>No Feature Available</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<script src="{{asset('new_js/roomCrud.js')}}"></script>