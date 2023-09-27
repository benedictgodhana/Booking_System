@extends('layout/layout')

@section('space-work')

<style>
    /* Card Styles */
    .card {
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .card-text {
        font-size: 1rem;
        color: #333;
    }

    /* Container for Cards */
    .container {
        padding: 20px;
    }

    /* Responsive Layout */
    @media (max-width: 768px) {
        .container {
            padding: 10px;
        }

        h5{
            text-align: center;
        }

        .card {
            margin-bottom: 10px;
        }

        /* Reduce the calendar size */
        #calendar {
            height: 200px;
            width: 30px;
            /* Adjust the height as needed */
            overflow-y: scroll;
            /* Add vertical scrollbar if necessary */
        }

        .fc button {
            background-color: yellowgreen;
            color: black;
            font-family: Arial, sans-serif;
            font-size: 20px;
            border: none;
            border-radius: 1px;
            padding: 8px 16px;
            margin: 4px;
            cursor: pointer;
        }

        /* Add this CSS to your existing styles */
        .calendar-container {
            max-height: 400px;
            /* Adjust the max height as needed */
            overflow-y: auto;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 10px;
        }

        body {
            overflow: hidden;
            
        }



    }
</style>

@if(Session::has('success'))
<div class="alert alert-success">
    {{ Session::get('success') }}
</div>
@endif

<script>
    setTimeout(function() {
        $(".alert").alert('close');
    }, 5000); // 5000 milliseconds (5 seconds), adjust as needed
</script>


<div class="row" style="width: auto; height: 86vh; overflow-x: hidden; overflow-y: scroll;">
    <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3></h3>

                <p>Number of pending bookings</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3></h3>

                <p>Total users</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3></h3>

                <p>Total users</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3></h3>

                <p>Total rooms</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="container">
        <button  style="border-radius:8px;border:1px white;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#createReservationModal">
            <i class="fas fa-plus"></i><strong style="margin-left:10px">Create Reservation</strong>
        </button>


        <div class="container">
            <h1 style="color: brown; font-weight: bold; margin-left: 370px">Booking Calendar</h1><br>
            <div class="calendar-container">
                <div id="calendar" style="max-width: 950px;"></div>
            </div>

            <div class="legend" style=" margin-left: 1120px;margin-top:-500px;width:200px">
                @foreach ($roomColors as $room => $color)
                <div>
                    <div class="legend-color" style=" margin-right: 5px; height: 20px; width: 20px;display: inline-block;background-color: {{ $color }};"></div> {{ $room }}
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <!-- Booking Graph -->
        <canvas id="bookingGraph" width="400" height="200"></canvas>
    </div>




    <!-- Modal for creating a new reservation -->
    <div class="modal fade" id="createReservationModal" tabindex="-1" role="dialog" aria-labelledby="createReservationModalLabel" aria-hidden="true">
        <div style="border-radius:10px 0px 10px 0px"  class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5  class="modal-title" id="createReservationModalLabel">Create Reservation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div  class="modal-body">
                    <!-- Reservation creation form -->
                    <form method="POST" action="{{ route('subadmin.createReservation') }}" onsubmit="return validateForm()">
                        @csrf
                        <div class="row">
                            <!-- User selection -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user"><i class="fas fa-user"></i> Select User:</label>
                                    <select class="form-control select2" id="user" name="user_id" required>
                                        <option value="">Select a user....</option> <!-- Add an empty option -->
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="room"><i class="fas fa-building"></i> Select Room:</label>
                                    <input type="hidden" id="roomCapacity" value="">
                                    <select class="form-control" id="selectRoom" name="selectRoom" required>
                                        @foreach($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Department selection -->

                        <div class="form-group">
                            <label for="items"><i class="fas fa-shopping-bag"></i> Select Items (maximum 5):</label>
                            <select id="items" name="items[]" multiple size="5" class="form-control">
                                @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->asset_tag }})</option>
                                @endforeach
                            </select>
                        </div>


                        <!-- Reservation date and time -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="reservationDate"><i class="fas fa-calendar"></i> Reservation Date:</label>
                                    <input type="date" class="form-control" id="booking_date" name="reservationDate" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="reservationTime"><i class="fas fa-clock"></i> Reservation Time:</label>
                                    <input type="time" class="form-control" id="booking_time" name="reservationTime" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="duration"><i class="fas fa-clock"></i> Duration (in hours):</label>
                            <input type="number" class="form-control" id="duration" name="duration" required>
                        </div>
                    </div>


                        <!-- End Time -->
                        <div class="form-group">
                    <label for="endtime"><i class="fas fa-clock"></i> End Time:</label>
                    <input type="text" class="form-control" id="timeLimit" name="timelimit" required readonly>
                </div>


                        <!-- Room selection -->

                        <div class="form-group">
                            <label for="event"><i class="fas fa-calendar-alt"></i> Event:</label>
                            <input type="text" class="form-control" id="event" name="event" required>
                        </div>

                        <!-- Add more form fields as needed -->
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-info" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Calendar initialization -->
    <script>
        $(document).ready(function() {
            // Define an array of colors for each room
            var roomColors = [
                'red',
                'blue',
                'green',
                'purple',
                'orange',
                'pink',
                'brown',
                'gray'
            ];

            $('#calendar').fullCalendar({
                defaultView: 'month',
                editable: false,
                events: @json($events),
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                dayClick: function(date, jsEvent, view) {
                    var today = new Date();
                    if (date >= today) {
                        window.location.href = '/login';
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'You cannot make a reservation for a past date.',
                        });
                    }
                },
                eventRender: function(event, element) {
                    // Assign a unique background color to each room's reservation
                    var roomIndex = roomColors.indexOf(event.room);
                    if (roomIndex !== -1) {
                        element.css('background-color', roomColors[roomIndex]);
                    }
                },
                eventMouseover: function(event, jsEvent, view) {
                    var tooltip = '<div class="tooltipevent" style="width:auto;height:auto;background:yellow;position:absolute;z-index:10001;padding:10px;border-radius:5px;box-shadow:0 0 5px #333;">' + '<br>Event: ' + event.title + '<br>Room: ' + event.room + '<br>Start: ' + moment(event.start).format('YYYY-MM-DD hh:mm A') + '<br>End: ' + moment(event.end).format('YYYY-MM-DD hh:mm A') + '</div>';
                    $("body").append(tooltip);
                    $(this).mouseover(function() {
                        $(this).css('z-index', 10000);
                        $('.tooltipevent').fadeIn('500');
                        $('.tooltipevent').fadeTo('10', 1.9);
                    }).mousemove(function(e) {
                        $('.tooltipevent').css('top', e.pageY + 10);
                        $('.tooltipevent').css('left', e.pageX + 20);
                    });
                },
                eventMouseout: function(event, jsEvent, view) {
                    $(this).css('z-index', 8);
                    $('.tooltipevent').remove();
                },
            });
        });
    </script>

    <script>
        // Initialize date picker
        $(function() {
            $("#reservationDate").datepicker();
        });
    </script>
    <!-- Include SweetAlert JS -->


    <script>
        function validateForm() {
            const user = document.getElementById('user').value;
            const reservationDate = document.getElementById('reservationDate').value;
            const reservationTime = document.getElementById('reservationTime').value;
            const room = document.getElementById('room').value;
            const timeLimit = document.getElementById('timeLimit').value;
            const event = document.getElementById('event').value;

            if (!user || !reservationDate || !reservationTime || !room || !timeLimit || !event) {
                showAlert('Error', 'Please fill in all the required fields.', 'error');
                return false; // Prevent form submission
            }
            const today = new Date().toISOString().slice(0, 10);

            if (reservationDate < today) {
                showAlert('Error', 'You cannot make a reservation for a past date.', 'error');
                return false; // Prevent form submission
            }

            // Check other form fields here if needed

            return true; // Allow form submission
        }

        function showAlert(title, text, type) {
            Swal.fire({
                icon: type,
                title: title,
                text: text,
            });
        }
    </script>
    <script>
        document.getElementById('reservationForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Assuming the form validation logic is in the validateForm function
            if (validateForm()) {
                // Form is valid, submit the form using AJAX or the default behavior
                // You can add an AJAX request here, or let the form submit naturally

                // Display the success alert
                showAlert('Success', 'Booking made successfully! Wait for Confirmation', 'success');
            }
        });

        function showAlert(title, text, type) {
            Swal.fire({
                icon: type,
                title: title,
                text: text,
            });
        }
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

    @endsection