@extends('layout/layout')

@section('space-work')

<style>
      @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");

    
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
      #calendar {
            max-width: 100%;
            background-color: #ffffff; /* Background color of the calendar */
            border: 1px solid #ccc; /* Border around the calendar */
            border-radius: 5px; /* Rounded corners */
            box-shadow: 0 0 5px #888; /* Box shadow for a subtle depth effect */
            padding: 10px;
            margin: 0px;
        }
        #calendar .fc-toolbar {
            background-color:darkblue; /* Header background color */
            color: #ffffff; /* Header text color */
            border-radius: 5px 5px 0 0; /* Rounded corners for the top */
        }
        #calendar .fc-toolbar button {
            background-color:yellowgreen;
            color: #ffffff;
            border: none;
            border-radius: 0;
            margin: 2px;
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

        #calendar .fc-event:hover {
            background-color: #0056b3;
        }

        /* Style the time display in the calendar */
        #calendar .fc-time {
            color: #333; /* Time text color */
            font-weight: bold;
        }
        .legend{

            margin-left: 1170px;
             margin-top:-500px;
              width:200px
        }
        .legend-color{
            margin-right: 5px; 
            height: 20px; width: 20px;
            display: inline-block;

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
      }
    </style>
<div class="row" style="margin: 4px, 4px; padding: 4px; width: auto; height: 86vh; overflow-x: hidden; overflow-y: scroll;">
    <div class="container">
        <h1 style="color: brown; font-weight: bold; margin-left: 370px">Booking Calendar</h1><br>
        <div class="calendar-container">
            <div id="calendar" style="max-width: 950px;"></div>
            <div class="legend" style=" margin-left: 1120px; margin-top: -500px; width: 200px;">
                @foreach ($roomColors as $room => $color)
                <div>
                    <div class="legend-color" style=" margin-right: 5px; height: 20px; width: 20px; display: inline-block; background-color: {{ $color }};"></div> {{ $room }}
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
                        window.location.href = "{{ route('booking') }}";
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
    @endsection