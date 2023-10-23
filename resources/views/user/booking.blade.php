@extends('layout/layout')

@section('space-work')
<style>
    .container {
        max-width: 100%;
    }
</style>

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Include SweetAlert CSS -->
<link rel="stylesheet" href="{{ asset('sweetalert2/dist/sweetalert2.min.css') }}">

<div class="container">
    <div class="card">
        <div class="card-header" style="background: darkblue">
            <h3 style="text-align: center; color: white" class="word">Reservation Form</h3>
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
                        <label for="selectRoom" class="form-label">Select Room</label>
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
                        <label for="capacity" class="form-label">Number of People Attending</label>
                        <input type="number" id="capacity" name="capacity" class="form-control" required min="1">
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
                            <input type="date" id="booking_date" name="reservationDate" class="form-control" required>
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
                            <input type="time" id="booking_time" name="reservationTime" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="durationHours" class="form-label">Duration (in hours):</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-clock"></i>
                                </span>
                            </div>
                            <select  id="hours" name="duration" class="form-select" required>
                                <option value="1">1 hour</option>
                                <option value="2">2 hours</option>
                                <option value="3">3 hours</option>
                                <option value="4">4 hours</option>
                                <option value="5">5 hours</option>
                                <option value="6">6 hours</option>
                                <option value="7">7 hours</option>
                                <option value="8">8 hours</option>
                                <option value="9">9 hours</option>
                                <option value="10">10 hours</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="durationMinutes" class="form-label">Duration (in minutes):</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-clock"></i>
                                </span>
                            </div>
                            <select id="minutes" name="duration" class="form-select" required>
                                <option value="5">5 minutes</option>
                                <option value="10">10 minutes</option>
                                <option value="15">15 minutes</option>
                                <option value="20">20 minutes</option>
                                <option value="25">25 minutes</option>
                                <option value="30">30 minutes</option>
                                <option value="35">35 minutes</option>
                                <option value="40">40 minutes</option>
                                <option value="45">45 minutes</option>
                                <option value="50">50 minutes</option>
                                <option value="55">55 minutes</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="event" class="form-label">Event Name:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-check"></i>
                                </span>
                            </div>
                            <input type="text" id="event" name="event" class="form-control" placeholder="Enter Event Name" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="timeLimit" class="form-label">End Reservation Time:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-clock"></i>
                                </span>
                            </div>
                            <input type="text" id="endTime" name="timeLimit" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="itemRequests" class="form-label">Select Items (Optional):</label>
                        <select id="itemRequests" name="itemRequests[]" class="form-control" multiple>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="comment" class="form-label">Comment (Optional):</label>
                        <textarea id="comment" name="comment" class="form-control" placeholder="Enter any comments or notes" oninput="countWords()"></textarea>
                        <p id="wordCount">Word count: 0/50</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Optional Requirements:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="setupAssistanceCheckbox">
                            <label class="form-check-label" for="setupAssistanceCheckbox">IT Setup Assistance</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3" id="setupAssistanceDescription" style="display: none;">
                    <label for="setupAssistanceDetails" class="form-label">Description of Services/Setup Needed:</label>
                    <div class="col-md-12">
                        <textarea name="additionalDetails" id="additionalDetails" cols="50" rows="3" placeholder="Kindly provide more details" oninput="limitWords(this)"></textarea>
                        <p>Word Count: <span id="wordCount1">0 words</span></p>
                    </div>
                </div>
                

                <div class="row mb-3">
                    <div class="col-md-12">
                        <button type="submit" value="submit" class="btn" style="background: darkblue; color: white">
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
  // Get references to the elements
var hoursInput = document.getElementById('hours');
var minutesInput = document.getElementById('minutes');
var bookingTimeInput = document.getElementById('booking_time'); // Use "booking_time" to match the HTML ID
var endTimeInput = document.getElementById('endTime');

// Add event listeners to the duration and booking time inputs
hoursInput.addEventListener('input', calculateEndTime);
minutesInput.addEventListener('input', calculateEndTime);
bookingTimeInput.addEventListener('input', calculateEndTime);

// Function to calculate the end time
function calculateEndTime() {
    var selectedHours = parseInt(hoursInput.value);
    var selectedMinutes = parseInt(minutesInput.value);
    
    var bookingTime = bookingTimeInput.value.split(':');
    var bookingHours = parseInt(bookingTime[0]);
    var bookingMinutes = parseInt(bookingTime[1]);

    if (!isNaN(selectedHours) && !isNaN(selectedMinutes) && !isNaN(bookingHours) && !isNaN(bookingMinutes)) {
        // Calculate the end time based on booking time
        var endTime = new Date();
        endTime.setHours(bookingHours + selectedHours);
        endTime.setMinutes(bookingMinutes + selectedMinutes);
        
        // Format the end time as 'hh:mm AM/PM'
        var formattedEndTime = endTime.toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        });
        
        // Update the end time input field
        endTimeInput.value = formattedEndTime;
    } else {
        // Handle invalid input
        endTimeInput.value = 'Invalid input';
    }
}

// Initialize the end time calculation
calculateEndTime();

</script>

<script>
        function limitWords(textarea) {
            var maxWords = 50;
            var text = textarea.value;
            var words = text.split(/\s+/);
            
            if (words.length > maxWords) {
                // Trim down the text to 50 words
                var trimmedText = words.slice(0, maxWords).join(" ");
                textarea.value = trimmedText;
            }

            // Display the word count
            var wordCount = words.length;
            document.getElementById("wordCount1").innerHTML = wordCount + " words";
        }
    </script>

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
    // JavaScript validation
function validateForm() {
    var selectRoom = document.getElementById('selectRoom');
    var roomCapacity = parseInt(selectRoom.options[selectRoom.selectedIndex].getAttribute('data-capacity'));
    var enteredCapacity = parseInt(document.getElementById('capacity').value);

    if (enteredCapacity > roomCapacity) {
        showAlert('Error', 'Entered capacity of ' + enteredCapacity + ' exceeds room capacity of ' + roomCapacity + '. Please select another room or reduce the capacity.', 'error');
        return false; // Prevent form submission
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
    document.getElementById('capacity').addEventListener('change', function () {
        var selectRoom = document.getElementById('selectRoom');
        var roomCapacity = parseInt(selectRoom.options[selectRoom.selectedIndex].getAttribute('data-capacity'));
        var enteredCapacity = parseInt(this.value);

        if (enteredCapacity > roomCapacity) {
    var errorMessage = 'Entered capacity of ' + enteredCapacity + ' exceeds room capacity of ' + roomCapacity + '. Please select another room or reduce the capacity.';
    alert(errorMessage);
    this.value = ''; // Clear the input
}

    });
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
<script>
    // Attach the function to the change event of the select element
document.getElementById('itemRequests').addEventListener('change', limitItemSelection);

</script>

<script>
    // Get references to the checkbox and the description text field
var setupAssistanceCheckbox = document.getElementById('setupAssistanceCheckbox');
var setupAssistanceDescription = document.getElementById('setupAssistanceDescription');

// Add an event listener to the checkbox
setupAssistanceCheckbox.addEventListener('change', function () {
    if (setupAssistanceCheckbox.checked) {
        // Checkbox is checked, show the description field
        setupAssistanceDescription.style.display = 'block';
    } else {
        // Checkbox is unchecked, hide the description field
        setupAssistanceDescription.style.display = 'none';
    }
});

</script>

<script>
    // Get a reference to the input element
    var bookingTimeInput = document.getElementById("booking_time");

    // Add an event listener to check the selected time
    bookingTimeInput.addEventListener("input", function() {
        var selectedTime = new Date("2000-01-01 " + bookingTimeInput.value);

        var startTime = new Date("2000-01-01 08:00:00"); // 8 AM
        var endTime = new Date("2000-01-01 20:00:00");  // 8 PM

        if (selectedTime < startTime || selectedTime > endTime) {
            // Invalid time selected
            alert("Please select a time between 8 AM and 8 PM.");
            bookingTimeInput.value = "08:00"; // Reset to 8 AM
        }
    });
</script>
<script>
    function countWords() {
    var comment = document.getElementById('comment').value;
    var words = comment.split(/\s+/).filter(function(word) {
        return word.length > 0;
    }).length;
    var wordCountElement = document.getElementById('wordCount');
    
    if (words > 50) {
        // If word count exceeds the limit, truncate the comment and update the count
        wordCountElement.textContent = 'Word count: 50 / 50 (Maximum limit reached)';
        document.getElementById('comment').value = comment.split(/\s+/).slice(0, 50).join(' ');
    } else {
        wordCountElement.textContent = 'Word count: ' + words + ' / 50';
    }
}

</script>
@endsection
