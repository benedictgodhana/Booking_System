<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Calendar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet" />

    <style>
        /* Calendar buttons */
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

        .fc button:hover {
            background-color: yellow;
        }

        /* Sidebar */
        .sidebar {
            height: 100%;
            width: 300px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: darkblue;
            padding-top: 20px;
            border-radius: 1px 5px;
        }

        /* Sidebar content */
        .sidebar-content {
            text-align: center;
            color: white;
        }

        /* Logo */
        .logo {
            width: 250px;
            margin-bottom: 20px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 50%;
                position: relative;
                height: auto;
            }

            .container {
                margin-left: 0;
            }
        }

        /* Mobile view styles */
        @media (max-width: 576px) {

            /* Adjust the sidebar for mobile view */
            .sidebar {
                width: 100%;
                height: auto;
                padding-top: 10px;
                text-align: center;
            }

            .logo {
                width: 150px;
                /* Adjust the logo size for mobile */
                margin-bottom: 10px;
                max-width: 350px;
            }

            /* Adjust the calendar and legend for mobile view */
            .calendar-container {
                flex-direction: column-reverse;
                /* Stack legend below the calendar */
            }

            .calendar {
                max-width: 100%;
                /* Make the calendar responsive */
            }

            /* Add styles for the legend */
            .legend {
                margin-left: 120px;
                /* Adjust this value to control the spacing between calendar and legend */
                background-color: white;
                /* Set the background color of the legend */
                padding: 10px;
                border-radius: 5px;
                box-shadow: 0 0 5px #333;
            }

            /* Add styles for the legend colors */
            .legend-color {
                width: 20px;
                height: 20px;
                display: inline-block;
                margin-right: 5px;
                border-radius: 50%;
            }


        }
    </style>
</head>

<body style="background-color:#FAF9F6;">
    <div class="sidebar">
        <div class="sidebar-content">
            <img src="logo/iLab white Logo-01.png" alt="Logo" class="logo">
            <hr style="border-color: white; border-width: 4px;">
            <div class="sidebar-buttons" style="padding:10px">
                <a href="/login" class="btn btn-success btn-block">Login</a>
                <a href="{{route('guest.booking.form')}}" style="background-color:red; color:white" class="btn btn- btn-block">Guest Booking</a>
            </div>
            <p></p>
        </div>
    </div>
    <br><br>

    <div class="container">
        <div class="calendar-container">
            <div class="calender" id="calendar" style="max-width: 1350px; width:1200px;margin-left:-20px"></div>
            <div class="legend" style=" margin-left: 1220px;margin-top:-500px;width:200px">
                @foreach ($roomColors as $room => $color)
                <div>
                    <div class="legend-color" style=" margin-right: 5px; height: 20px; width: 20px;display: inline-block;background-color: {{ $color }};"></div> {{ $room }}
                </div>
                @endforeach
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

                    // Format the reservation time to include "am" or "pm"
                    var formattedTime = moment(event.start).format('hh:mm A');

                    // Append the formatted time to the event title
                    element.find('.fc-title').append('<br>' + formattedTime);
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




</body>

</html>