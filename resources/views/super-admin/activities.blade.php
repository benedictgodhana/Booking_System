@extends('layout/layout')

@section('space-work')

<style>
    /* Style the pagination container */
/* Style the simple pagination container */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

/* Style the individual pagination links */
.pagination .page-item {
    margin: 0 5px;
    list-style: none;
}

/* Style the current/active page link */
.pagination .page-item.active .page-link {
    background-color: #007bff; /* Change to your preferred color */
    border-color: #007bff; /* Change to your preferred color */
    color: #fff; /* Text color for active page */
}

/* Style the previous and next page links */
.pagination .page-item .page-link {
    color: #007bff; /* Text color for non-active pages */
    border: 1px solid #007bff; /* Border color for non-active pages */
    border-radius: 4px;
}

/* Style on hover for previous and next page links */
.pagination .page-item .page-link:hover {
    background-color: #007bff; /* Change to your preferred color */
    border-color: #007bff; /* Change to your preferred color */
    color: #fff; /* Text color on hover */
}

</style>


<div style="margin: 4px, 4px; padding: 4px; width: auto; height: 86vh; overflow-x: hidden;">
    <div class="container-fluid">
        <div class="card vh-100">
            <h1 class="mt-4" style="margin-left:20px">System Activities</h1>

            <!-- Filter and Search Controls -->
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="filter">Filter By:</label>
                            <select class="form-control" id="filter" onchange="filterAndSearch()">
                                <option value="">All</option>
                                <option value="action">Action</option>
                                <option value="user">User</option>
                                <!-- Add more filter options as needed -->
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="search">Search:</label>
                            <input type="text" class="form-control" id="search" placeholder="Search..." onkeyup="filterAndSearch()">
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- PDF Printing Button -->
            <button class="btn btn-primary"><a href="{{ route('generate-pdf') }}" style="color: white; text-decoration: none;"><i class="fas fa-print"></i>  <strong>Generate PDF</strong></a></button>

            <div class="card-body overflow-auto">
                <table class="table table-bordered table-striped" id="activityTable">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Table rows go here -->
                        @foreach ($activities as $activity)
                        <tr>
                            <td>
                                @if ($activity->user)
                                {{ $activity->user->name }}
                                @else
                                User not found
                                @endif
                            </td>
                            <td>{{ $activity->action }}</td>
                            <td>{{ $activity->description }}</td>
                            <td>{{ $activity->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="pagination">
    {{ $activities->links() }}
        </div>
            </div>
        </div>
    </div>
</div>

<!-- Include your custom styles here -->
<style>
    /* Add your custom CSS styles here */
    .container-fluid {
        padding: 0;
    }

    h1 {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .card {
        height: 100vh;
        margin: 0;
        border: none;
        border-radius: 0;
    }

    .card-body {
        overflow-y: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .table th,
    .table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .table th {
        background-color: #f2f2f2;
    }

    .table-striped tbody tr:nth-child(odd) {
        background-color: #f9f9f9;
    }

    .pagination {
        margin: 0;
        padding-top: 10px;
        justify-content: center;
    }
</style>

<!-- Include the jsPDF library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<script>
    // Function to generate a PDF from the table
    function generatePDF() {
        const doc = new jsPDF();
        doc.autoTable({ html: '#activityTable' }); // 'activityTable' is the ID of your table element
        doc.save('system_activities.pdf');
    }

    // Attach a click event listener to the PDF printing button
    document.getElementById('pdf-print-btn').addEventListener('click', generatePDF);
</script>

<script>
    // JavaScript function to filter and search table rows
    function filterAndSearch() {
        // Get selected filter value
        var filter = document.getElementById("filter").value.toLowerCase();
        // Get search input value
        var search = document.getElementById("search").value.toLowerCase();
        // Get the table rows
        var rows = document.getElementById("activityTable").getElementsByTagName("tr");

        // Loop through all table rows
        for (var i = 1; i < rows.length; i++) { // Start from index 1 to skip the table header row
            var row = rows[i];
            var user = row.getElementsByTagName("td")[0].textContent.toLowerCase(); // Get user column value
            var action = row.getElementsByTagName("td")[1].textContent.toLowerCase(); // Get action column value
            var description = row.getElementsByTagName("td")[2].textContent.toLowerCase(); // Get description column value
            var timestamp = row.getElementsByTagName("td")[3].textContent.toLowerCase(); // Get timestamp column value

            // Check if the row matches the filter and search criteria
            if ((filter === "" || filter === "all" || user.includes(filter) || action.includes(filter)) &&
                (search === "" || user.includes(search) || action.includes(search) || description.includes(search) || timestamp.includes(search))) {
                row.style.display = ""; // Show the row
            } else {
                row.style.display = "none"; // Hide the row
            }
        }
    }
</script>
@endsection
