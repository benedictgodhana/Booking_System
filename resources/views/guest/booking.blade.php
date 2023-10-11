<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>RoomBooking</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <style>
      @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");

      :root {
        --header-height: 3rem;
        --nav-width: 78px;
        --first-color: #4723d9;
        --first-color-light: #afa5d9;
        --white-color: #f7f6fb;
        --body-font: "Nunito", sans-serif;
        --normal-font-size: 1rem;
        --z-fixed: 100;
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


        .form-container {
        background-color: #f7f7f7;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Style form labels */
    .form-label {
        font-weight: bold;
    }

    /* Style form inputs */
    .form-control {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    /* Style the submit button */
    .btn-primary {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
    }

    /* Style the secondary button */
    .btn-secondary {
        background-color: #ccc;
        color: #000;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
    }

    /* Add some spacing between elements */
    .mb-3 {
        margin-bottom: 20px;
    }

    /* Style the footer */
    footer {
        color: #555;
        font-size: 14px;
        text-align: center;
        margin-top: 20px;
    }

        .show {
    left: 0;
  }

  /* Add a transition for smoother sidebar animation */
  .l-navbar {
    transition: left 0.5s;
  }

  /* Adjust the width of the sidebar in the "show" state */
  .l-navbar.show {
    left: 0;
  }


        .btn-reserve{
            margin-left: 320px;
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

            margin-left: 1270px;
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
        
        
      }
    </style>
  </head>
  <body id="body-pd">
    <header class="header" id="header">
      <div class="header_toggle">
        <i class="bx bx-menu" id="header-toggle"></i>
      </div>
     
    </header>
    <div class="l-navbar" id="nav-bar">
      <nav class="nav">
        <div>
          <a href="#" class="nav_logo">
            <span><img style="max-width:240px;margin-left:-40px;" src="/logo/iLab white Logo-01.png" alt=""/></span>
          </a><hr style="border:2px solid #ccc">
          <div class="nav_list" style="margin-left:0px;padding-left:10px">
                
                <a href="{{ route('guest.booking.form') }}" class="nav_link" data-toggle="tooltip" data-placement="right" title="Guest Reservation">
                <i class="bx bx-user-plus nav_icon"></i>
                <span class="nav_name"><strong>Guest Reservation</strong></span>
            </a><hr>
            <a href="/" class="nav_link" data-toggle="tooltip" data-placement="right" title="Home">
                <i class="bx bx-home nav_icon"></i> <!-- Add the bx-home icon for Home -->
                <span class="nav_name"><strong>Home</strong></span>
                </a>
                <hr>

          </div>
        </div>
      </nav>
    </div>

    <div class="height-100 bg-light">
  <!-- Button to trigger the Reservations Modal -->
  <!-- Button to open the modal -->
  <div class="card">
    <div class="card-header">
        <h5 class="card-title">Reservation Form</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('guest.booking.submit') }}" method="POST">
            @csrf
            <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="full_name"><i class="bx bx-user"></i><strong> Full Name</strong></label>
                            <input type="text" class="form-control" id="full_name" name="guest_name" required placeholder="Enter Your FullName">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="email"> <i class="bx bx-envelope"></i><strong>Email</strong></label>
                            <input type="email" class="form-control" id="email" name="guest_email" required placeholder="Enter Your Email">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="room"> <i class="bx bx-building"></i><strong>Select Room</strong></label>
                            <select class="form-control" id="room" name="room" required>
                            <option class="form-control" value="">Select Room......</option>
                                @foreach ($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
              <div class="col-md-12">
                  <label for="itemRequests" class="form-label">Select Items:</label>
                  <select id="itemRequests" name="itemRequests[]" class="form-control" multiple>
                      @foreach($items as $item)
                          <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                  </select>
              </div>
            </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="booking_date"><i class="bx bx-calendar"></i><strong>Booking Date</strong></label>
                            <input type="date" class="form-control" id="booking_date" name="booking_date" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="booking_time"> <i class="bx bx-clock"></i><strong>Booking Time</strong></label>
                            <input type="time" class="form-control" id="booking_time" name="booking_time" required min="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="time_limit"> <i class="bx bx-clock"></i><strong> Duration (in hours)</strong></label>
                            <input type="number" class="form-control" id="duration" name="duration">
                        </div>
                    </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="end_of_reservation">
                            <i class="bx bx-clock"></i><strong> End of Reservation</strong>
                        </label>
                        <input type="text" class="form-control" id="end_of_reservation" name="timelimit" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="event"> <i class="bx bx-calendar-alt"></i> <strong>Event Title</strong></label>
                            <input type="text" class="form-control" id="event" name="event" placeholder="Enter Event Title">
                        </div>
                    </div>

                    <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="department">
                    <i class="bx bx-building"></i><strong>Department</strong>
                </label>
                <input
                    id="department"
                    name="guest_department"
                    class="form-control"
                    list="departmentList"
                    placeholder="Search or enter your department"
                />
        <datalist id="departmentList">
            <option value="CIPIT">Centre for Intellectual Property and Information Technology Law (CIPIT)</option>
            <option value="SCES">Strathmore School of Computing and Engineering Sciences (SCES)</option>
            <option value="PARTNERSHIP">Partnership</option>
            <option value="SAIRC">Strathmore Academy for International Research Collaboration</option>
            <option value="STH">Strathmore School of Tourism and Hospitality</option>
            <option value="SUMC">Strathmore University Medical Centre (SUMC)</option>
            <option value="SERC">Strathmore Energy Research Centre (SERC) </option>
            <option value="SIMS">Strathmore University Institute of Mathematical Sciences (SIMS)</option>
            <option value="SHSS">School of Humanities and Social Sciences</option>
            <option value="SBS">Strathmore Business School</option>
            <option value="MENTORSHIP">Mentorship</option>
            <option value="FINANCE">Finance </option>
            <option value="FAO"> Strathmore University Financial Aid Office</option>
            <option value="PNC">Strathmore People and Culture</option>
            <option value="SUF"></option>
            <option value="SUSA">Strathmore University student affairs</option>



            <!-- Add more department options here -->
        </datalist>
    </div>
</div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="comments"><i class="bx bx-comment"></i><strong> Comments (Optional)</strong></label>
            <textarea class="form-control" id="comments" name="comment" rows="4" placeholder="Enter any comments or notes"></textarea>
        </div>
    </div>
</div>



                    <div id="endOfReservation"></div>
                <!-- Checkbox for Requirements -->
                <div class="row mb-3">
    <div class="col-md-12">
        <label class="form-label">Optional Requirements:</label>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="setupAssistance" onchange="toggleTextField()">
            <label class="form-check-label" for="setupAssistance">IT Setup Assistance</label>
        </div>

        <div id="itemsList" style="display: none;">
            <textarea name="" id="additionalDetails" cols="50" rows="3" placeholder="Kindly Provide more details"></textarea>
        </div><br>

                     

                


                <input type="hidden" name="guest" value="1">
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-primary" type="submit">Submit</button>

                    </div>
                </div>
                <footer style="color:black;font-size:17px;font-weight:800" class="text-center mt-4">
                    @iLabAfrica. All Rights Reserved. &copy; 2023 Strathmore
                </footer>
        </form>
    </div>
</div>


<script>
    // JavaScript to handle showing/hiding fields based on checkboxes
    $(document).ready(function () {
        $("#itServices").change(function () {
            $("#itemsList").toggle(this.checked);
        });

        // Add more checkbox change handlers here
    });
</script>
     <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
    ></script>
    <script type="text/javascript">
      document.addEventListener("DOMContentLoaded", function (event) {
        const showNavbar = (toggleId, navId, bodyId, headerId) => {
          const toggle = document.getElementById(toggleId),
            nav = document.getElementById(navId),
            bodypd = document.getElementById(bodyId),
            headerpd = document.getElementById(headerId);

          // Validate that all variables exist
          if (toggle && nav && bodypd && headerpd) {
            toggle.addEventListener("click", () => {
              // show navbar
              nav.classList.toggle("show");
              // change icon
              toggle.classList.toggle("bx-x");
              // add padding to body
              bodypd.classList.toggle("body-pd");
              // add padding to header
              headerpd.classList.toggle("body-pd");
            });
          }
        };

        showNavbar("header-toggle", "nav-bar", "body-pd", "header");

        /*===== LINK ACTIVE =====*/
        const linkColor = document.querySelectorAll(".nav_link");

        function colorLink() {
          if (linkColor) {
            linkColor.forEach((l) => l.classList.remove("active"));
            this.classList.add("active");
          }
        }
        linkColor.forEach((l) => l.addEventListener("click", colorLink));

        // Your code to run since DOM is loaded and ready
      });
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



        <!-- Include your JavaScript scripts or links here -->
</body>


<script>
  // Get references to the input and other department input elements
const departmentInput = document.getElementById("department");
const otherDepartmentField = document.getElementById("otherDepartmentField");
const otherDepartmentInput = document.getElementById("otherDepartment");

// Add an event listener to the department input element
departmentInput.addEventListener("input", function () {
    // Check if the user's input matches any department from the list
    const inputIsInList = Array.from(departmentInput.list.options).some(
        (option) => option.value === departmentInput.value
    );

    if (inputIsInList) {
        // If the input matches a department in the list, hide the "Other" department field
        otherDepartmentField.style.display = "none";
        // Clear the "Other" department input field
        otherDepartmentInput.value = "";
    } else {
        // If the input does not match any department in the list, show the "Other" department field
        otherDepartmentField.style.display = "block";
    }
});

// Add an event listener to the "Other" department input field
otherDepartmentInput.addEventListener("input", function () {
    // Handle the input in the "Other" department field
    // This is where you can process the user's input for the "Other" department
    const otherDepartmentValue = otherDepartmentInput.value;
    // You can use otherDepartmentValue as needed, e.g., save it to a variable or send it to the server
});

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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Select relevant input fields
        const durationInput = document.getElementById("duration");
        const bookingTimeInput = document.getElementById("booking_time");
        const endOfReservationInput = document.getElementById("end_of_reservation");

        // Function to update the end time based on duration and booking time
        function updateEndTime() {
            const duration = parseFloat(durationInput.value) || 0; // Parse duration as a number
            const bookingTime = bookingTimeInput.value || "00:00"; // Get booking time as a string

            if (duration > 0) {
                // Calculate end time
                const [hours, minutes] = bookingTime.split(":").map(Number);
                const endTime = new Date();
                endTime.setHours(hours + Math.floor(duration), minutes + (duration % 1) * 60);

                // Format the end time as "hh:mm AM/PM"
                const endHours = endTime.getHours() % 12 || 12;
                const endMinutes = endTime.getMinutes();
                const amPm = endTime.getHours() >= 12 ? "PM" : "AM";

                // Update the end_of_reservation input field
                endOfReservationInput.value = `${endHours}:${endMinutes.toString().padStart(2, "0")} ${amPm}`;
            } else {
                // Clear the end_of_reservation input if duration is not valid
                endOfReservationInput.value = "";
            }
        }

        // Listen for changes in duration and booking time inputs
        durationInput.addEventListener("input", updateEndTime);
        bookingTimeInput.addEventListener("input", updateEndTime);
    });
</script>

<script>
  // Get references to the select and input elements
const departmentSelect = document.getElementById("department");
const otherDepartmentField = document.getElementById("otherDepartmentField");
const otherDepartmentInput = document.getElementById("otherDepartment");

// Add an event listener to the department select element
departmentSelect.addEventListener("change", function () {
    // Check if the selected option is "Other"
    if (departmentSelect.value === "Others") {
        // Show the input field when "Other" is selected
        otherDepartmentField.style.display = "block";
    } else {
        // Hide the input field for other selections
        otherDepartmentField.style.display = "none";
        // Clear the input field value
        otherDepartmentInput.value = "";
    }
});

// Add an event listener to the input field for searching departments
otherDepartmentInput.addEventListener("input", function () {
    const searchValue = otherDepartmentInput.value.trim().toUpperCase();
    
    // Loop through the options in the select element
    for (let i = 0; i < departmentSelect.options.length; i++) {
        const option = departmentSelect.options[i];
        
        // Check if the option text contains the search value
        if (option.text.toUpperCase().includes(searchValue)) {
            // Show the matching option
            option.style.display = "";
        } else {
            // Hide non-matching options
            option.style.display = "none";
        }
    }
});

</script>
<script>
    function toggleTextField() {
        var checkbox = document.getElementById("setupAssistance");
        var textField = document.getElementById("itemsList");

        if (checkbox.checked) {
            textField.style.display = "block";
        } else {
            textField.style.display = "none";
        }
    }
</script>

     <!-- Calendar initialization -->
       </body>
</html>
