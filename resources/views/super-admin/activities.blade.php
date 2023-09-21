@extends('layout/layout')

@section('space-work')
<div class="container">
    <h1>System Activities</h1>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>User</th>
                <th>Action</th>
                <th>Description</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
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

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item {{ $activities->currentPage() == 1 ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $activities->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            @for ($i = 1; $i <= $activities->lastPage(); $i++)
                <li class="page-item {{ $i == $activities->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $activities->url($i) }}">{{ $i }}</a>
                </li>
                @endfor

                <li class="page-item {{ $activities->currentPage() == $activities->lastPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $activities->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
        </ul>
    </nav>
</div>
@endsection

<style>
    /* Add your custom CSS styles here */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    h1 {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .table {
        width: 1000%;
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
        margin-top: 20px;
    }
</style>