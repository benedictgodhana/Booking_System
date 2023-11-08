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

    /* CSS for the tooltip */
.capacity-tooltip {
    position: relative;
}

.tooltip {
    visibility: hidden;
    width: 200px;
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 5px;
    padding: 5px;
    position: absolute;
    z-index: 1;
    bottom: 120%;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity 0.3s;
}

.capacity-tooltip:hover .tooltip {
    visibility: visible;
    opacity: 1;
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
                <select class="form-control" id="selectRoom" name="room" required>
                    <option class="form-control" value="">Select Room......</option>
                    @foreach ($rooms as $room)
                    <option value="{{ $room->id }}" data-capacity="{{ $room->capacity }}">{{ $room->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="capacity"><i class="bx bx-user"></i><strong>Number of people</strong></label>
                <input type="hidden" id="roomCapacity" value="">
                <input type="number" id="capacity" name="capacity" class="form-control" onmouseover="updateCapacityTooltip()" min="1">
            </div>
        </div>
    </div>
    <div class="col-md-6">
    <div class="form-group">
        <label class="form-label" for="contact"><i class="bx bx-phone"></i><strong> Contact</strong></label>
        <input type="tel" class="form-control" id="contact" name="contact" placeholder="Enter Your Contact" pattern="^\+254\d{9}$" value="+254">
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
                <input type="time" class="form-control" id="booking_time" name="booking_time">
            </div>
        </div>
    </div>

    <div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label" for="time_limit">
                <i class="bx bx-clock"></i><strong> Duration</strong>
            </label>
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label" for="hours">Hours</label>
                    <select class="form-control" id="hours" name="duration">
                        <!-- Generate options for hours -->
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
            </div>
        </div>
    </div>
    <div class="col-md-6" style="margin-top:30px">
        <div class="form-group">
            <label class="form-label" for="end_of_reservation">
                <i class="bx bx-clock"></i><strong> End of Reservation</strong>
            </label>
            <input type="text" class="form-control" id="endTime" name="timelimit" readonly>
        </div>
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
                <input type="text" id="department" name="guest_department" class="form-control" list="department-list" placeholder="Select or type your department">
                <datalist id="department-list">
                    @foreach($departments as $department)
                    <option value="{{ $department->name }}">
                    @endforeach
                </datalist>
            </div>
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
            <p>Word Count: <span id="wordCount1">0/50</span></p>
        </div>
    </div>

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
        function limitWords(textarea) {
            var maxWords = 50;
            var text = textarea.value;
            var words = text.split(/\s+/).filter(Boolean); // Filter to remove empty strings

            if (words.length > maxWords) {
                // Trim down the text to 50 words
                var trimmedText = words.slice(0, maxWords).join(" ");
                textarea.value = trimmedText;
            }

            // Display the word count
            var wordCount = words.length;
            document.getElementById("wordCount1").innerHTML = wordCount + "/" + maxWords;
        }
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

        // Get the current date in the format 'dd/mm/yyyy'
        var currentDate = new Date();
        var day = String(currentDate.getDate()).padStart(2, '0');
        var month = String(currentDate.getMonth() + 1).padStart(2, '0');
        var year = currentDate.getFullYear();
        var formattedDate = day + '/' + month + '/' + year;

        // Set the minimum date of the booking_date input to the current date
        bookingDateInput.min = formattedDate;
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



     <!-- Calendar initialization -->
       </body>
</html>
