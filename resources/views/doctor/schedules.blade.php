@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Availability Slots</h1>
    <p>Render Marker: {{ uniqid('schedules_') }}</p>


    <!-- Debugging: Add a unique identifier -->
    <p>Unique Identifier: {{ uniqid() }}</p>

    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Success message -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add Slot Form -->
    <form method="POST" action="{{ route('doctor.schedules.store') }}">
        @csrf
        <div class="form-group mb-3">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="start_time">Start Time</label>
            <input type="time" name="start_time" id="start_time" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="end_time">End Time</label>
            <input type="time" name="end_time" id="end_time" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Slot</button>
    </form>

    <!-- Button to navigate to Scheduled Appointments -->
    <a href="{{ route('doctor.appointments') }}" class="btn btn-success mt-3">
        View Scheduled Appointments
    </a>

    <!-- Display Availability Slots -->
    <h2 class="mt-4">Your Availability Slots</h2>
    @if ($schedules->isEmpty())
        <div class="alert alert-info">No availability slots found.</div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->date }}</td>
                        <td>{{ $schedule->start_time }}</td>
                        <td>{{ $schedule->end_time }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection