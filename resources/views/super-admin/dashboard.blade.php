@extends('layout/layout')

@section('space-work')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



<style>
      @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");
.container{
    max-width: 100%;
}

      .fc button {
            color: black;
            font-family: Arial, sans-serif;
            font-size: 20px;
            border: none;
            border-radius: 1px;
            padding: 8px 16px;
            margin: 4px;
            cursor: pointer;
        }

        .fc button:hover {
            background-color: yellow;
        }

        #calendar {
            max-width: 100% ;
            background-color: #ffffff; /* Background color of the calendar */
            border: 1px solid #ccc; /* Border around the calendar */
            border-radius: 5px; /* Rounded corners */
            box-shadow: 0 0 5px #888; /* Box shadow for a subtle depth effect */
            padding: 10px;
            margin: 0px;
        }
        #calendar .fc-toolbar {
            background-color:#ec7d30; /* Header background color */
            color: #ffffff; /* Header text color */
            border-radius: 5px 5px 0 0; /* Rounded corners for the top */
        }
        #calendar
        #calendar .fc-toolbar button {
            color:black;
            border: none;
            border-radius: 0;
            margin: 2px;
            font-weight: 600;
        }
        #calendar .fc-toolbar button:hover {
            background-color: #0056b3;
        }

        /* Style the events in the calendar */
        #calendar .fc-event {
            background-color:yellowgreen; /* Event background color */
            color: #ffffff; /* Event text color */
            border: none;
            border-radius: 5px;
            padding: 5px;
            margin: 2px;
        }

        .fc-header-toolbar .fc-left button,
      .fc-header-toolbar .fc-right button {
          text-transform: capitalize;
      }

        #calendar .fc-event:hover {
            background-color: #0056b3;
        }
        /* Style the time display in the calendar */
        #calendar .fc-time {
            color: #333; /* Time text color */
            font-weight: bold;
            display: none;
        }


      *,
      ::before,
      ::after {
        box-sizing: border-box;
      }

      body {
        position: relative;
        margin: var(--header-height) 0 0 0;
        padding: 0 1rem;
        font-family: var(--body-font);
        font-size: var(--normal-font-size);
        transition: 0.5s;
      }

      a {
        text-decoration: none;
      }

      .header {
        width: 100%;
        height: var(--header-height);
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 1rem;
        background-color: var(--white-color);
        z-index: var(--z-fixed);
        transition: 0.5s;
      }

      .header_toggle {
        color: var(--first-color);
        font-size: 1.5rem;
        cursor: pointer;
      }

      .header_img {
        width: 35px;
        height: 35px;
        display: flex;
        justify-content: center;
        border-radius: 50%;
        overflow: hidden;
      }

      .header_img img {
        width: 40px;
      }

      .l-navbar {
        position: fixed;
        top: 0;
        left: -30%;
        width: var(--nav-width);
        height: 100vh;
        background-color:darkblue;
        padding: 0.5rem 1rem 0 0;
        transition: 0.5s;
        z-index: var(--z-fixed);
      }

      .nav {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: hidden;
      }

      .nav_logo,
      .nav_link {
        display: grid;
        grid-template-columns: max-content max-content;
        align-items: center;
        column-gap: 1rem;
        padding: 0.5rem 0 0.5rem 1.5rem;
      }

      .nav_logo {
        margin-bottom: 2rem;
      }

      .nav_logo-icon {
        font-size: 1.25rem;
        color: var(--white-color);
      }

      .nav_logo-name {
        color: var(--white-color);
        font-weight: 700;
      }

      .nav_link {
        position: relative;
        color: var(--first-color-light);
        margin-bottom: 1.5rem;
        transition: 0.3s;
      }

      .nav_link:hover {
        color: var(--white-color);
      }

      .nav_icon {
        font-size: 1.25rem;
      }

      .show {
        left: 0;
      }

      .body-pd {
        padding-left: calc(var(--nav-width) + 1rem);
      }

      .active {
        color: var(--white-color);
      }

      .active::before {
        content: "";
        position: absolute;
        left: 0;
        width: 2px;
        height: 32px;
        background-color: var(--white-color);
      }

      .height-100 {
        height: 100vh;
      }

      @media screen and (min-width: 768px) {
        body {
          margin: calc(var(--header-height) + 1rem) 0 0 0;
          padding-left: calc(var(--nav-width) + 2rem);
        }

        .header {
          height: calc(var(--header-height) + 1rem);
          padding: 0 2rem 0 calc(var(--nav-width) + 2rem);
        }

        .header_img {
          width: 40px;
          height: 40px;
        }

        .header_img img {
          width: 45px;
        }

        .l-navbar {
          left: 0;
          padding: 1rem 1rem 0 0;
        }



        .body-pd {
          padding-left: calc(var(--nav-width) + 188px);
        }
      }</style>
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
            <h3>{{ $pendingBookingsCount }}</h3> <!-- Inject the pending bookings count here -->
                <p>pending Reservations</p>
            </div>
            <div class="icon">
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
            <h3>{{ $usersCount }}</h3> <!-- Inject the total users count here -->
                <p>Total users</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a  href="{{ route('superAdminUsers') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box bg-success">
            <div class="inner">
            <h3>{{ $reservationsAcceptedCount }}</h3> <!-- Inject the accepted reservations count here -->
                <p>Reservations accepted</p>
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
            <h3 style="color:white">{{ $roomsCount }}</h3> <!-- Inject the total rooms count here -->
                <p style="color:white">Total rooms</p>
            </div>
            <div class="icon">
            </div>
            <a href="{{ route('superAdminRooms') }}" class="small-box-footer"><span style="color:white">  More info </span>
              <i style="color:white" class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- ./col -->

    <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box " style="background:#ec7d30;color:white">
            <div class="inner">
            <h3>{{ $itemsCount }}</h3> <!-- Inject the accepted reservations count here -->
                <p>Items</p>
            </div>
            <div class="icon">
            </div>
            <a  href="{{ route('superAdminItems') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box bg-danger ">
            <div class="inner">
            <h3>{{$departmentsCount }}</h3> <!-- Inject the total rooms count here -->
                <p>Departments</p>
            </div>
            <div class="icon">
            </div>
            <a href="{{ route('superAdminDepartment') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>



    <div class="container">
        <button  style="border-radius:8px;border:1px white;background:darkblue" type="button" class="btn " data-toggle="modal" data-target="#createReservationModal">
            <i style="color:white" class="fas fa-plus"></i><strong style="margin-left:10px;color:white">Create Reservation</strong>
        </button>


        <div class="container">

        <h1>Booking Calendar</h1> <!-- Add your page title here -->
        <div class="calendar-container">
            <!-- Current Time Display -->
            <div class="current-time">
              <button style=" background: rgba(255, 255, 15, 0.5); /* Semi-transparent white background */
                    border: none;
                    border-radius: 25px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08); /* Box shadow for the glass effect */
                    color: #333; /* Text color */
                    padding: 10px;
                    transition: background 0.3s ease;font-weight:900" class="btn btn-success glass-effect"><strong>Current Time:</strong> <span id="current-time"></span></button>
            </div><br>

            <!-- Calendar -->
            <div class="calender" id="calendar"></div><br>
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Reservation Bar Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 650px; max-width: 100%;"></canvas>
                </div>
              </div>


            <!-- Legend -->

        </div>
    </div>
    </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
    ></script>





    <!-- Modal for creating a new reservation -->
    <div class="modal fade" id="createReservationModal" tabindex="-1" role="dialog" aria-labelledby="createReservationModalLabel" aria-hidden="true">
        <div style="border-radius:10px 0px 10px 0px"  class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: darkblue;">
                    <h5  class="modal-title" id="createReservationModalLabel" style="color:white">Create Reservation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div  class="modal-body">
                    <!-- Reservation creation form -->
                    <form method="POST" action="{{ route('superadmin.createReservation') }}" onsubmit="return validateForm()">
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
                                    <option class="form-control" value="">Select Room......</option>
                                    @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}" data-capacity="{{ $room->capacity }}">{{ $room->name }}</option>
                                    @endforeach
                                </select>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="capacity"><i class="bx bx-user"></i><strong>Number of people</strong></label>
                <input type="hidden" id="roomCapacity" value="">
                <input type="number" id="capacity" name="capacity" class="form-control" onmouseover="updateCapacityTooltip()" min="1">
            </div>
        </div>

                        <!-- Department selection -->

                        <div class="form-group">
                            <label for="items"><i class="fas fa-shopping-bag"></i> Select Items (maximum 5):</label>
                            <select id="items" name="itemRequests[]" multiple size="5" class="form-control">
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
                                    <input type="time" class="form-control" id="booking_time" name="reservationTime" required >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="duration"><i class="fas fa-clock"></i> Duration (in hours):</label>
                            <select  id="duration" name="duration" class="form-select" required>
                                <option value="0">0 hours</option>
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
                <label class="form-label" for="minutes">Minutes</label>
                <select class="form-control" id="minutes" name="duration">
                    <!-- Generate options for minutes -->
                        <option value="0">0 minutes</option>
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

                        <div class="row mb-3">
    <div class="col-md-12">
        <label for="itemRequests" class="form-label">Select Items (Optional):<em style="font-size:14px">*Please press shift + ctrl for multiple selection.</em><br>
</label>
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
                <div class="col-md-12">
        <label class="form-label">Have you requested a meal set-up for this event?</label>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="mealSetupCheckbox" name="mealSetupCheckbox">
            <label class="form-check-label" for="mealSetupCheckbox">Yes, I have requested a meal set-up</label><br>
            <em style="font-size:14px">*Please note that all cafeteria bookings should be communicated to the cafeteria department.</em><br>
            <em style="font-size:14px">*Please Inform cafeteria team to clear the setup as soon as the meeting is done.</em>


        </div>
    </div>
    <div class="row mb-3" id="mealSetupDescription" style="display: none;">
    <label for="mealSetupDetails" class="form-label">Meal Set-Up Details:</label>
    <div class="col-md-12">
        <textarea name="mealSetupDetails" id="mealSetupDetails" cols="50" rows="3" placeholder="  Provide details about your meal set-up requirements" oninput="countMealSetupWords()" maxlength="50"></textarea>
        <p id="mealSetupWordCount">Word count: 0/50</p>
    </div>
</div>
<br>




                        <!-- Add more form fields as needed -->
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-info" value="Submit" style="background: darkblue;">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

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

            // Initialize the current time display
            function updateTime() {
                var currentTime = new Date();
                var hours = currentTime.getHours();
                var minutes = currentTime.getMinutes();
                var ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; // Handle midnight (0:00)
                minutes = minutes < 10 ? '0' + minutes : minutes; // Add leading zero to minutes
                var timeString = hours + ':' + minutes + ' ' + ampm;
                document.getElementById('current-time').textContent = timeString;
            }

            // Update the current time every second
            setInterval(updateTime, 1000);

            // Initialize the FullCalendar
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
                        var selectedDate = date.format('MM-DD-YYY');

        // Fill the reservationDate input field with the selected date
                     $('#reservationDate').val(selectedDate);
                        $('#createReservationModal').modal('show');
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

                    var formattedStartTime = moment(event.start).format('DD-MM-YYYY hh:mm A');
                var formattedEndTime = moment(event.end).format('DD-MM-YYYY hh:mm A');

                // Append the formatted time to the event title
                element.find('.fc-title').append('<br>Start: ' + formattedStartTime);
                element.find('.fc-title').append('<br>End: ' + formattedEndTime);
                element.find('.fc-title').prepend('Room: ' + event.room + '<br>');
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
    var minutesInput = document.getElementById('minutes');
    var reservationTimeInput = document.getElementById('booking_time');
    var timeLimitInput = document.getElementById('timeLimit');

    function updateEndTime() {
        var duration = parseInt(durationInput.value);
        var minutes = parseInt(minutesInput.value);

        // Ensure the duration and minutes are within valid ranges
        if (duration > 10) {
            durationInput.value = 10;
            duration = 10;
        }

        if (minutes > 55) {
            minutesInput.value = 55;
            minutes = 55;
        }

        var reservationTime = reservationTimeInput.value;

        if (reservationTime) {
            // Use moment.js for better date and time handling
            var startTime = moment('2000-01-01 ' + reservationTime, 'YYYY-MM-DD HH:mm');
            startTime.add(duration, 'hours').add(minutes, 'minutes');

            // Format the end time as 'hh:mm'
            var endTime = startTime.format('HH:mm');

            timeLimitInput.value = endTime;
        }
    }

    // Attach event listeners to the duration, minutes, and reservation time inputs
    durationInput.addEventListener('input', updateEndTime);
    minutesInput.addEventListener('input', updateEndTime);
    reservationTimeInput.addEventListener('input', updateEndTime);

    // Trigger initial calculation
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
<script src="../../plugins/chart.js/Chart.min.js"></script>
<script>
    // Prepare the data for the bar chart
    var dailyReservationData = {
        datasets: @json($dailyReservations), // Use the formatted dataset array
    };

    // Get the canvas element
    var ctx = document.getElementById('barChart').getContext('2d');

    // Create the bar chart
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: dailyReservationData, // Use the prepared data
        options: {
            scales: {
                x: {
                    stacked: true, // Stack bars for each room on the x-axis
                },
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
</script>

<script>
    // Get a reference to the input element
    var bookingTimeInput = document.getElementById("booking_time");

    // Add an event listener to check the selected time
    bookingTimeInput.addEventListener("input", function() {
        var selectedTime = new Date("2000-01-01 " + bookingTimeInput.value);

        var startTime = new Date("2000-01-01 7:30:00"); // 8 AM
        var endTime = new Date("2000-01-01 19:00:00");  // 8 PM

        if (selectedTime < startTime || selectedTime > endTime) {
            // Invalid time selected
            alert("Please select a time between 7:30 AM and 7 PM.");
            bookingTimeInput.value = "07:30"; // Reset to 8 AM
        }
    });
</script>

<script>
    // Apply Select2 to the itemRequests field
    $(document).ready(function() {
        $('#itemRequests').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            placeholder: 'Select or type to add items',
        });
    });
</script>



<script>
    function countMealSetupWords() {
        var mealSetupDetails = document.getElementById('mealSetupDetails').value;
        var words = mealSetupDetails.split(/\s+/).filter(function (word) {
            return word.length > 0;
        }).length;
        var wordCountElement = document.getElementById('mealSetupWordCount');

        if (words > 50) {
            // If word count exceeds the limit, truncate the input and update the count
            wordCountElement.textContent = 'Word count: 50 / 50 (Maximum limit reached)';
            document.getElementById('mealSetupDetails').value = mealSetupDetails.split(/\s+/).slice(0, 50).join(' ');
        } else {
            wordCountElement.textContent = 'Word count: ' + words + ' / 50';
        }
    }
</script>
<script>
    // Get references to the checkbox and the description text field
    var mealSetupCheckbox = document.getElementById('mealSetupCheckbox');
    var mealSetupDescription = document.getElementById('mealSetupDescription');

    // Add an event listener to the checkbox
    mealSetupCheckbox.addEventListener('change', function () {
        if (mealSetupCheckbox.checked) {
            // Checkbox is checked, show the description field
            mealSetupDescription.style.display = 'block';
        } else {
            // Checkbox is unchecked, hide the description field
            mealSetupDescription.style.display = 'none';
        }
    });
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




    @endsection
