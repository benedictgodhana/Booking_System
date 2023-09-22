@extends('layout/layout')

@section('space-work')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Include SweetAlert CSS -->
<link rel="stylesheet" href="{{ asset('sweetalert2/dist/sweetalert2.min.css') }}">

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary">
            <h3 style="text-align: center;" class="word">Reservation Form</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-info" id="success-alert">
                {{ session('success') }}
            </div>

            <script>
                // Automatically hide the alert after 3 seconds (adjust the duration as needed)
                setTimeout(function() {
                    document.getElementById("success-alert").style.display = "none";
                }, 3000);
            </script>
            @endif

            <form action="{{ route('submit.reservation') }}" method="post" onsubmit="return validateForm()">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="capacity" class="form-label">Select Room</label>
                        <input type="hidden" id="roomCapacity" value="">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-door-open"></i>
                                </span>
                            </div>
                            <select id="selectRoom" name="selectRoom" class="form-control">
                                <option value="">Select Room....</option>
                                @foreach($rooms as $room)
                                <option value="{{ $room->id }}" data-capacity="{{ $room->capacity }}">{{ $room->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="selectRoom" class="form-label">Number of people attending</label>
                        <!-- Add a hidden input field to store room capacity -->
                        <input type="hidden" id="roomCapacity" value="">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-users"></i>
                                </span>
                            </div>
                            <input type="number" id="capacity" name="capacity" class="form-control" onmouseover="updateCapacityTooltip()">
                        </div>
                    </div>
                </div>



                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="booking_date" class="form-label">Date of Reservation:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="date" id="booking_date" name="reservationDate" class="form-control" placeholder="Enter Your Reservation Date">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="booking_time" class="form-label">Reservation Time:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-clock"></i>
                                </span>
                            </div>
                            <input type="time" id="booking_time" name="reservationTime" class="form-control" min="08:00" max="20:00">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="duration" class="form-label">Duration (in hours):</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-clock"></i>
                                </span>
                            </div>
                            <input type="number" id="duration" name="duration" class="form-control">
                        </div>
                    </div>


                    <div class="col-md-6">
                        <label for="event" class="form-label">Event:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-check"></i>
                                </span>
                            </div>
                            <input type="text" id="event" name="event" class="form-control" placeholder="Enter Event Details">
                        </div>
                    </div>
                </div>

                <!-- Display the calculated end time -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="timeLimit" class="form-label">End Reservation Time:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-clock"></i>
                                </span>
                            </div>
                            <input type="text" id="timeLimit" name="timeLimit" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <!-- Checkbox for Requirements -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Requirements:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="itServices">
                            <label class="form-check-label" for="itServices">IT Services</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="setupAssistance">
                            <label class="form-check-label" for="setupAssistance">Setup Assistance</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="requestItems">
                            <label class="form-check-label" for="requestItems">Request Items</label>
                        </div>
                    </div>
                </div>


                <div class="row mb-3" id="itemRequestField" style="display: none;">
                    <div class="col-md-12">
                        <label for="itemRequests" class="form-label">Requested Items:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">

                            </div>
                            <select id="itemRequests" name="itemRequests[]" class="form-control" multiple>
                                @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                    <span>
                        <i class="fas fa-check-circle"></i> Submit
                    </span>
                    </button>
                                        </div>
                </div>
            </form>

            @include('sweet::alert')
        </div>
    </div>
</div>

<script>
    // Initialize date picker
    $(function() {
        $("#booking_date").datepicker();
    });
</script>
<!-- Include SweetAlert JS -->
<script src="{{ asset('sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

<script>
    // JavaScript validation
    function validateForm() {
        var selectRoom = document.getElementById('selectRoom');
        var roomCapacity = parseInt(selectRoom.options[selectRoom.selectedIndex].getAttribute('data-capacity'));
        var enteredCapacity = parseInt(document.getElementById('capacity').value);

        if (enteredCapacity > roomCapacity) {
            showAlert('Error', 'Entered capacity of ' + enteredCapacity + ' exceeds room capacity of ' + roomCapacity + '. Please select another room or reduce the capacity.', 'error');
            return false;
        }

        // Continue with other form validations
        var items = document.getElementById('itemRequests');
        var reservationDate = document.getElementById('booking_date');
        var reservationTime = document.getElementById('booking_time');
        var timeLimit = document.getElementById('timeLimit');
        var event = document.getElementById('event');

        // Check other fields for validation (e.g., if they are empty or meet specific criteria)

        // If all validations pass, the form submission will proceed
        return true;
    }

    // Display SweetAlert
    function showAlert(title, message, icon) {
        Swal.fire({
            title: title,
            text: message,
            icon: icon,
            timer: 5000,
            showConfirmButton: false
        });
    }
</script>

<script>
    // Function to toggle the visibility of the item request field
    function toggleItemRequestField() {
        var itemRequestField = document.getElementById('itemRequestField');
        var requestItemsCheckbox = document.getElementById('requestItems');

        if (requestItemsCheckbox.checked) {
            itemRequestField.style.display = 'block'; // Show the field
        } else {
            itemRequestField.style.display = 'none'; // Hide the field
        }
    }

    // Attach an event listener to the "Request Items" checkbox
    document.getElementById('requestItems').addEventListener('change', toggleItemRequestField);
</script>

<script>
    function limitItemSelection() {
        // Get the select element and the selected options
        var itemSelect = document.getElementById('itemRequests');
        var selectedOptions = itemSelect.selectedOptions;

        // Check if the number of selected options exceeds the limit (5)
        if (selectedOptions.length > 5) {
            // Display an alert message or take any other action
            alert('You can select a maximum of 5 items.');

            // Deselect the last selected item
            selectedOptions[selectedOptions.length - 1].selected = false;
        }
    }

    // Attach the function to the change event of the select element
    document.getElementById('itemRequests').addEventListener('change', limitItemSelection);
</script>
<script>
            document.addEventListener('DOMContentLoaded', function() {
                var bookingDateInput = document.getElementById('booking_date');

                // Get the current date in the format 'YYYY-MM-DD'
                var currentDate = new Date().toISOString().split('T')[0];

                // Set the minimum date of the booking_date input to the current date
                bookingDateInput.min = currentDate;
            });
        </script>


<script>
    // Attach an event listener to the "Request Items" checkbox
    document.getElementById('requestItems').addEventListener('change', function() {
        if (this.checked) {
            // Get the user's name from the form
            var userName = document.getElementById('userName').value; // Replace 'userName' with the actual input field ID

            // Send an AJAX request to send an email
            $.ajax({
                type: 'POST',
                url: '/send-reservation-email', // Replace with the actual route for sending the email
                data: {
                    userName: userName
                },
                success: function(response) {
                    // Handle the response (e.g., show a success message)
                },
                error: function(error) {
                    // Handle errors if the email sending fails
                }
            });
        }
    });
</script>

<script>
    // Get references to the elements
   // Function to update the capacity tooltip based on the selected room
function updateCapacityTooltip() {
    var selectRoom = document.getElementById('selectRoom');
    var capacityInput = document.getElementById('capacity');
    
    // Get the selected room's capacity
    var selectedRoom = selectRoom.options[selectRoom.selectedIndex];
    var roomCapacity = selectedRoom.getAttribute('data-capacity');
    
    // Set the tooltip (title) to display the room's capacity
    capacityInput.setAttribute('title', 'Room Capacity: ' + roomCapacity + ' people');
}

// Attach an event listener to the room selection field
document.getElementById('selectRoom').addEventListener('change', updateCapacityTooltip);

// Initialize the tooltip when the page loads
updateCapacityTooltip();

</script>

<script>
    var durationInput = document.getElementById('duration');
var reservationTimeInput = document.getElementById('booking_time');
var timeLimitInput = document.getElementById('timeLimit');

durationInput.addEventListener('input', function() {
    var duration = parseInt(durationInput.value);

    // Ensure the duration does not exceed 8 hours
    if (duration > 10) {
        durationInput.value = 10 // Set the duration to the maximum (8 hours)
        duration = 10;
    }

    // Get the selected reservation time
    var reservationTime = reservationTimeInput.value;

    // Calculate the end of reservation
    if (reservationTime) {
        var startTime = new Date('2000-01-01T' + reservationTime);
        startTime.setHours(startTime.getHours() + duration);

        // Format the end time as 'hh:mm'
        var endTime = startTime.toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        });

        // Update the timeLimit input with the calculated end time
        timeLimitInput.value = endTime;
    }
});

</script>

@endsection