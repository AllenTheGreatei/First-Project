@if ($features)
@php
    $no = 1;
@endphp
    @foreach ($features as $feature)
        <tr class="row{{$feature->id}}">
            <td>{{ $no++ }}</td>
            <td>{{ $feature->name}}</td>
            <td><button class ="update-feature-btn" data-toggle="modal" data-target="#update_feature" value="{{ $feature->id}}">EDIT</button>
                <button class ="delete-feature-btn" value="{{ $feature->id}}">DELETE</button>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td>No Feature Available</td>
    </tr>
@endif