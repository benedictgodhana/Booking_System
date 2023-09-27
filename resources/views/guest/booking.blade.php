<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guest Boooking form</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <!-- SweetAlert CSS -->
    <link rel="styleshxeet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- SweetAlert JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        body {
            background-color: white;
        }

        .login-page {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-box {
            width: 600px;
            max-width: 100%;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 30px;
        }

        .login-logo img {
            width: 100%;
            max-width: 300px;
            height: auto;
            margin: 0 auto 20px;
            display: block;
        }

        .icheck-primary input:checked+label::before {
            border-color: #007bff;
            background-color: #007bff;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="card card-outline card-primary">
        <a href='/' class="btn btn-primary"><i class="fas fa-arrow-left"></i><strong> Back to Home page</strong> </a>
        <div class="card-header text-center">
            <div class="login-logo">
                <img src="logo/LOGO_2.png" alt="Logo">
            </div>
        </div>
        <!-- ... Your existing HTML code ... -->
        <!-- ... Your existing HTML code ... -->
        <div class="container">
            <h1 style="text-align: center;">Guest Booking Form</h1>
            <hr style="background-color:black">
            <form action="{{ route('guest.booking.submit') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="full_name"><i class="fas fa-user"></i> Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="guest_name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="email"> <i class="fas fa-envelope"></i> Email</label>
                            <input type="email" class="form-control" id="email" name="guest_email" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="room"> <i class="fas fa-building"></i> Select Room</label>
                            <select class="form-control" id="room" name="room" required>
                                @foreach ($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="item"><i class="fas fa-shopping-bag"></i> Select Item (Optional)</label>
                            <select class="form-control" id="item" name="item_id">
                                <option class="form-control" value="">Select an item (optional)</option>
                                @foreach ($items as $item)
                                <option class="form-control" value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="booking_date"><i class="fas fa-calendar"></i> Booking Date</label>
                            <input type="date" class="form-control" id="booking_date" name="booking_date" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="booking_time"> <i class="fas fa-clock"></i> Booking Time</label>
                            <input type="time" class="form-control" id="booking_time" name="booking_time" required min="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="time_limit"> <i class="fas fa-clock"></i> Duration (in hours)</label>
                            <input type="number" class="form-control" id="duration" name="duration">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="event"> <i class="fas fa-calendar-alt"></i> Event</label>
                            <input type="text" class="form-control" id="event" name="event">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="department"> <i class="fas fa-building"></i> Department</label>
                        <select id="department" name="guest_department" class="form-control">
                            <option value="eHealth">eHealth</option>
                            <option value="IT Outsourcing & BITCU">IT Outsourcing & BITCU</option>
                            <option value="Digital Learning">Digital Learning</option>
                            <option value="Data Science">Data Science</option>
                            <option value="IoT">IoT</option>
                            <option value="IT Security">IT Security</option>
                            <option value="iBizAfrica">iBizAfrica</option>
                            <option value="IR &EE">IR &EE</option>
                            <option value="PR">PR</option>
                            <option value="ADM">@iLab Admin</option>
                            <option value="Others">Other</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6" id="otherDepartmentField" style="display:none;">

                            <input style="margin-top:30px;width:565px;margin-left:5px" id="otherDepartment" type="text" name="other_department" class="form-control" placeholder="Enter your department" style="width:500px">
                        </div>
                    </div>
                </div><br>
                    <div id="endOfReservation"></div>
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

                        <div id="itemsList" style="display: none;">
                            <label for="selectedItems">Select Items:</label>
                            <select multiple class="form-control" id="selectedItems">
                                <option value="Item 1">Item 1</option>
                                <option value="Item 2">Item 2</option>
                                <option value="Item 3">Item 3</option>
                                <!-- Add more items as needed -->
                            </select>
                        </div>

                        <textarea id="selectedItemsDisplay" name="selectedItems" style="display: none;"></textarea>

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


                <input type="hidden" name="guest" value="1">
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
                <footer style="color:black;font-size:17px;font-weight:800" class="text-center mt-4">
                    Strathmore University. All Rights Reserved. &copy; 2023 Strathmore
                </footer>
            </form><br>
        </div>


        <!-- Include your JavaScript scripts or links here -->
        <!-- Include your JavaScript scripts or links here -->
        <!-- ... Your existing HTML code ... -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var bookingDateInput = document.getElementById('booking_date');

                // Get the current date in the format 'YYYY-MM-DD'
                var currentDate = new Date().toISOString().split('T')[0];

                // Set the minimum date of the booking_date input to the current date
                bookingDateInput.min = currentDate;
            });
        </script>



        <!-- Include your JavaScript scripts or links here -->
</body>
<script>
    // Function to toggle the "other department" field
    function toggleOtherDepartmentField() {
        var departmentSelect = document.getElementById('department');
        var otherDepartmentField = document.getElementById('otherDepartmentField');
        var otherDepartmentInput = document.getElementById('otherDepartment');

        if (departmentSelect.value === 'Others') {
            otherDepartmentField.style.display = 'block';
            otherDepartmentInput.style.display = 'block'; // Add this line to make the input field visible
            otherDepartmentInput.required = true;
        } else {
            otherDepartmentField.style.display = 'none';
            otherDepartmentInput.style.display = 'none'; // Add this line to hide the input field
            otherDepartmentInput.required = false;
        }
    }

    // Add an event listener to the department select
    document.getElementById('department').addEventListener('change', toggleOtherDepartmentField);

    // Call the function initially to set the initial state
    toggleOtherDepartmentField();
</script>

<script>
    // Function to validate the email domain
    function validateEmailDomain() {
        var emailInput = document.getElementById('email');
        var email = emailInput.value;

        if (!/^[A-Za-z0-9._%+-]+@strathmore\.edu$/i.test(email)) {
            Swal.fire({
                title: 'Error',
                text: 'Please enter a valid email address from @strathmore.edu domain.',
                icon: 'error',
                timer: 5000, // Adjust the time you want the alert to be visible (in milliseconds)
                showConfirmButton: false // Hide the "OK" button
            });
            emailInput.value = '';
            emailInput.focus();
        }
    }

    // Add an event listener to validate the email domain when the field loses focus
    document.getElementById('email').addEventListener('blur', validateEmailDomain);
</script>
<script>
    // Get references to the elements
    var reservationTimeInput = document.getElementById('reservationTime');
    var durationInput = document.getElementById('duration');
    var timeLimitInput = document.getElementById('timeLimit');

    // Add an event listener to the duration input
    durationInput.addEventListener('input', function() {
        // Get the selected reservation time
        var reservationTime = reservationTimeInput.value;

        // Get the entered duration
        var duration = parseInt(durationInput.value);

        // Calculate the end of reservation
        if (reservationTime && !isNaN(duration)) {
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
    // Attach an event listener to the "Request Items" checkbox
    document.getElementById('requestItems').addEventListener('change', function() {
        if (this.checked) {
            // Get the user's name from the form
            var userName = document.getElementById('userName').value; // Replace 'userName' with the actual input field ID
            var selectedItems = document.getElementById('selectedItems').value; // Replace 'selectedItems' with the actual textarea ID

            // Send an AJAX request to the server-side script to send the email
            $.ajax({
                type: 'POST',
                url: '/send-reservation-email', // Replace with the actual server-side endpoint
                data: {
                    userName: userName,
                    selectedItems: selectedItems
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
    // Get the checkbox and the items list
    const requestItemsCheckbox = document.getElementById('requestItems');
    const itemsList = document.getElementById('itemsList');
    const selectedItemsDisplay = document.getElementById('selectedItemsDisplay');
    const selectedItems = document.getElementById('selectedItems');

    // Add an event listener to the checkbox
    requestItemsCheckbox.addEventListener('change', function() {
        if (requestItemsCheckbox.checked) {
            // If checkbox is checked, show the items list
            itemsList.style.display = 'block';
        } else {
            // If checkbox is unchecked, hide the items list and clear the selected items
            itemsList.style.display = 'none';
            selectedItemsDisplay.value = '';
        }
    });

    // Add an event listener to the select element to update the selected items
    selectedItems.addEventListener('change', function() {
        const selectedOptions = Array.from(selectedItems.options)
            .filter(option => option.selected)
            .map(option => option.value);

        selectedItemsDisplay.value = selectedOptions.join(', ');
    });
</script>


</html>