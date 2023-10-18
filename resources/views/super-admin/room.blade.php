@extends('layout/layout')

@section('space-work')
<div class="card">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody> 
            @foreach($rooms as $room)
            <tr>
                <td>{{$room->name}}</td>
                <td>{{$room->description}}</td>
                <td>{{$room->capacity}}</td>
                <td>
                <button class="btn btn-primary" data-toggle="modal" data-target="#editModal{{$room->id}}">Edit</button>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{$room->id}}">Delete</button>
                </td>   
                </td>
            </tr>
            @endforeach
        </tbody> 
    </table>
</div>










@foreach($rooms as $room)
<!-- Edit Modal -->
<div class="modal fade" id="editModal{{$room->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$room->id}}" aria-hidden="true">
    <!-- Modal content goes here -->
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal{{$room->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{$room->id}}" aria-hidden="true">
    <!-- Modal content goes here -->
</div>
@endforeach
@endsection
