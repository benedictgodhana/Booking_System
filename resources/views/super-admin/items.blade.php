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
@if(session('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
@endif
<script>
    // Wait for the document to be ready
    $(document).ready(function () {
        // Check if the success alert element exists
        var successAlert = $('#success-alert');
        if (successAlert.length) {
            // Automatically close the alert after 5 seconds (adjust the time as needed)
            setTimeout(function () {
                successAlert.alert('close'); // Close the alert
            }, 5000); // 5000 milliseconds (5 seconds)
        }
    });
</script>


<div class="card">
    <div class="card-body">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addItemModal">
    Add Asset
</button>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Asset Tag</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->asset_tag }}</td>
                    <td>
                        <!-- Delete Button -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteItemModal{{ $item->id }}">
                            Delete
                        </button>
                        
                        <!-- Update Button -->
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateItemModal{{ $item->id }}">
                            Update
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
      

    </div>
</div>
<div class="pagination">
    {{ $items->links() }}
</div>
<!-- Button to trigger the modal -->

<!-- Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemModalLabel">Add Asset</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your form for adding assets here -->
                <form action="{{ route('superAdminAddItems') }}" method="POST">              
                    @csrf
                    <div class="form-group">
                        <label for="itemName">Item Name</label>
                        <input type="text" class="form-control" id="itemName" name="name" placeholder="Enter Item Name">
                    </div>
                    <div class="form-group">
                        <label for="assetTag">Asset Tag</label>
                        <input type="text" class="form-control" id="assetTag" name="asset_tag" placeholder="Enter Asset Tag">
                    </div>
                    <!-- Move the Submit button inside the form -->
                    <button type="submit" class="btn btn-primary">Save</button> <!-- You can add your save logic here -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Modals for Delete and Update -->
@foreach ($items as $item)
<!-- Delete Item Modal -->
<!-- Delete Item Modal Form -->
<div class="modal fade" id="deleteItemModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteItemModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteItemModalLabel{{ $item->id }}">Delete Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add any confirmation message or item details here -->
                <p>Are you sure you want to delete the item "{{ $item->name }}"?</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('superAdminDeleteItem', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endforeach

<!-- Update Item Modal -->
@foreach ($items as $item)
<div class="modal fade" id="updateItemModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="updateItemModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateItemModalLabel{{ $item->id }}">Update Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Update Item Form -->
                <form action="{{ route('superAdminUpdateItem', ['id' => $item->id]) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- Use the PUT method for updating -->
                    <div class="form-group">
                        <label for="updateItemName{{ $item->id }}">Item Name</label>
                        <input type="text" class="form-control" id="updateItemName{{ $item->id }}" name="name" value="{{ $item->name }}" placeholder="Enter Item Name">
                    </div>
                    <div class="form-group">
                        <label for="updateAssetTag{{ $item->id }}">Asset Tag</label>
                        <input type="text" class="form-control" id="updateAssetTag{{ $item->id }}" name="asset_tag" value="{{ $item->asset_tag }}" placeholder="Enter Asset Tag">
                    </div>
                    <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
                </form>
            </div>
            
        </div>
    </div>
</div>
@endforeach

@endsection
