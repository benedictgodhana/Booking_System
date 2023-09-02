@extends('layout/layout')

@section('space-work')

<style>
    body {
        font-family: Arial, sans-serif;
    }

    h2 {
        color: #333;
    }

    form {
        width: 80%;
        /* Set the form width to 80% of the container */
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
    }

    label {
        flex-basis: 100%;
        /* Ensure labels take up the full width of their container */
        margin-bottom: 5px;
        font-weight: bold;
        color: #555;
    }

    input[type="text"],
    input[type="date"],
    input[type="time"],

    select {
        flex-basis: 54%;
        /* Set the width of input/select elements to 48% of their container */
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    select {
        height: 36px;
    }

    input[type="submit"] {
        flex-basis: 54%;
        /* Ensure the submit button takes up the full width of its container */
        background-color: #3498db;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #2980b9;
    }

    /* Style for the multiple-select element */
    .styled-select {
        width: 50%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
        /* Add a white background color */
        height: auto;
        /* Allow the select to grow with content */
        min-height: 36px;
        /* Set a minimum height for the select */
    }

    /* Style for the options in the select */
    .styled-select option {
        padding: 5px;
    }
</style>

<!-- Include SweetAlert CSS -->
<link rel="stylesheet" href="{{ asset('sweetalert2/dist/sweetalert2.min.css') }}">

<h2>Reservation Form</h2>

<form action="{{ route('submit.reservation') }}" method="post" onsubmit="return validateForm()">
    @csrf
    <div class="form-group" style="width:54%;height:60px">
        <label for="items">Select Items (maximum 5):</label>
        <select id="items" name="items[]" multiple size="5" class="styled-select">
            @foreach($items as $item)
            <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->asset_tag }})</option>
            @endforeach
        </select>

    </div>


    <label for="reservationDate">Date of Reservation:</label>
    <input type="date" id="reservationDate" name="reservationDate" placeholder="Enter Your Reservation Date">

    <label for="reservationTime">Reservation Time:</label>
    <input type="time" id="reservationTime" name="reservationTime">

    <label for="selectRoom">Select Room:</label>
    <select id="selectRoom" name="selectRoom">
        <option value="">Select Room....</option>
        @foreach($rooms as $room)
        <option value="{{ $room->id }}">{{ $room->name }}</option>
        @endforeach
    </select>

    <label for="timeLimit">Time Limit:</label>
    <input type="time" id="timeLimit" name="timeLimit">
    <label for="event">Event (Optional):</label>
    <input type="text" id="event" name="event" placeholder="Enter Event Details">


    <input type="submit" value="Submit" onclick="showAlert('Success', 'Booking made successfully! Wait for Confirmation', 'success')">
    @include('sweet::alert')
</form>

<script>
    // Initialize date picker
    $(function() {
        $("#reservationDate").datepicker();
    });
</script>
<!-- Include SweetAlert JS -->
<script src="{{ asset('sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

<script>
    function validateForm() {
        // Perform form validation here
        var items = document.getElementById('items');
        var reservationDate = document.getElementById('reservationDate');
        var reservationTime = document.getElementById('reservationTime');
        var selectRoom = document.getElementById('selectRoom');
        var timeLimit = document.getElementById('timeLimit');

        if (items.value === '' || reservationDate.value === '' || reservationTime.value === '' || selectRoom.value === '' || timeLimit.value === '') {
            // Show a SweetAlert error notification for incomplete fields
            showAlert('Error', 'Please fill in all fields', 'error');
            return false; // Prevent form submission
        }

        // Check if the selected date has passed
        var selectedDate = new Date(reservationDate.value);
        var currentDate = new Date();
        if (selectedDate < currentDate) {
            // Show a SweetAlert error for past dates
            showAlert('Error', 'You cannot book for a past date', 'error');
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }

    // Function to display SweetAlert
    function showAlert(title, message, icon) {
        Swal.fire({
            title: title,
            text: message,
            icon: icon,
            timer: 5000, // Adjust the time you want the alert to be visible (in milliseconds)
            showConfirmButton: false // Hide the "OK" button
        });
    }
</script>

@endsection