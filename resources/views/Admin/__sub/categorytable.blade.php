@if ($categories)
@php
    $no = 1;
@endphp
    @foreach ($categories as $category)
        <tr class="row{{$category->id}}">
            <td>{{ $no++ }}</td>
            <td>{{ $category->Name}}</td>
            <td><button class ="update-category-btn"  data-toggle="modal" data-target="#update_category" value="{{ $category->id }}">EDIT</button>
                <button class ="delete-category-btn" value="{{ $category->id}}">DELETE</button></td>
        </tr>
    @endforeach
    <button id="num" value="{{ $no }}" hidden></button>
@else
<tr>
    <td>No Categories Available</td>
@endif
{{-- <script src="{{asset('new_js/roomCrud.js')}}"></script> --}}