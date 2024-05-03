@if ($facilities)
@php
    $no = 1;
@endphp
    @foreach ($facilities as $facility)
        <tr class="row{{$facility->id}}">
            <td>{{ $no++ }}</td>
            <td>{{ $facility->name}}</td>
            <td><button class ="update-facility-btn" data-toggle="modal" data-target="#update_facility" value="{{ $facility->id}}">EDIT</button>
                <button class ="delete-facility-btn" value="{{ $facility->id}}">DELETE</button></td>
        </tr>
    @endforeach
    <button id="num" value="{{ $no }}" hidden></button>
@else
<tr>
    <td>No Facility Available</td>
@endif