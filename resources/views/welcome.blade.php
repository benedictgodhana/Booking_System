<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Calendar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet" />

    <style>
        /* Sidebar */
        .sidebar {
            height: 100%;
            width: 350px;
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
            width: 150px;
            /* Adjust the logo's width as needed */
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-content">
            <img src="logo/LOGO_2png" alt="Logo" class="logo" style="width: 300px; height: auto;">
            <hr style="border-color: white; border-width: 4px;">
            <div class="sidebar-buttons">
                <a href="/login" class="btn btn-success btn-block">Login</a>
                <a href="/register" class="btn btn-secondary btn-block">Register</a>
            </div>
            <!-- Replace 'path-to-your-logo.png' with the actual path to your logo image -->
            <p></p>
        </div>
    </div>
    <div class="container">
        <h1>Booking Calendar</h1>
        <div id="calendar"></div>
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
            $('#calendar').fullCalendar({
                defaultView: 'month',
                editable: false,
                events: @json($events), // Ensure that the room name is included in $events

                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },

                dayClick: function(date, jsEvent, view) {
                    var today = new Date();
                    if (date >= today) {
                        // Redirect to login/register page for future dates
                        window.location.href = '/login'; // Replace with your login URL
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'You cannot make a reservation for a past date.',
                        });

                    }
                },

                eventMouseover: function(event, jsEvent, view) {
                    // Display event details with room information
                    var tooltip = '<div class="tooltipevent" style="width:auto;height:auto;background:#f7f7f7;position:absolute;z-index:10001;padding:10px;border-radius:5px;box-shadow:0 0 5px #333;">' + event.title + '<br>Room: ' + event.room + '<br>Start: ' + event.start.format('YYYY-MM-DD HH:mm:ss') + '<br>End: ' + event.end.format('YYYY-MM-DD HH:mm:ss') + '</div>';
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
                    // Hide event details when the mouse leaves the event
                    $(this).css('z-index', 8);
                    $('.tooltipevent').remove();
                },
            });
        });
    </script>


</body>

</html>