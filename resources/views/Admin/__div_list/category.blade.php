<div class="category-container bg-white p-4 rounded">
    {{-- add modal --}}
    <div class="modal fade" id="add_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal"role="document">
        <div class="modal-content"  >
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add New Room Type</h5>
            </div>
            <div class="modal-body">
                <form action="add_category_form">
                    <div class="form-group">
                        <label class="form-label">New Room Type</label>
                        <input type="text" id="category_name" name ="category_name" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close" >Close</button>
            <button type="button" class="btn btn-primary" id="save_category">Save</button>
            </div>
        </div>
        </div>
    </div>
{{-- edit modal --}}
    <div class="modal fade" id="update_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal"role="document">
        <div class="modal-content"  >
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Room Type</h5>
            </div>
            <div class="modal-body">
                <form action="add_category_form">
                    <div class="form-group">
                        <label class="form-label">Room Type</label>
                        <input type="text" hidden id="id_hidden">
                        <input type="text" id="edit_category_name" name ="edit_category_name" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="eclose" >Close</button>
            <button type="button" class="btn btn-primary" id="save_edit_category">Save</button>
            </div>
        </div>
        </div>
    </div>
    <div class="wrap p-3">
        <h4 style="color:#787bff;font-size:1.5em;font-weight:600">Room Category</h4>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_category">Add New Room Type</button>
    </div>
    <div class="table">
        <table class = "user-list-table">
            <thead  >
                <tr>
                    <th style="color:white;font-size:1em">NO.</th>
                    <th style="color:white;font-size:1em">Name</th>
                    <th style="color:white;font-size:1em">Action</th>
                </tr>
            </thead>
            <tbody id ="table_body" class="tb_category">
                @if ($categories)
                @php
                    $no = 1;
                @endphp
                    @foreach ($categories as $category)
                        <tr class="row{{$category->id}}">
                            <td>{{ $no++ }}</td>
                            <td>{{ $category->Name}}</td>
                            <td><button class ="update-category-btn" data-toggle="modal" data-target="#update_category" value="{{ Crypt::encryptstring($category->id)}}"><i class='fa fa-edit mr-1' style='color:#efefeb'></i></button>
                                <button class ="delete-category-btn" value="{{ Crypt::encryptstring($category->id) }}"><i class='fa fa-trash mr-1' style='color:#f2f3ed'></i></button></td>
                        </tr>
                    @endforeach
                    <button id="num" value="{{ $no }}" hidden></button>
                @else
                <tr>
                    <td>No Room Type Available</td>
                @endif
                
            </tbody>
        </table>
    </div>
</div>

<script src="{{asset('new_js/roomCrud.js')}}"></script>
<script>
    var category_tb = '{{ route("category_tb") }}';
</script>