<!-- resources/views/appointments/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Book a New Appointment</h1>
    <form method="POST" action="{{ route('appointments.store') }}">
        @csrf
        <div class="form-group mb-3">
            <label for="doctor_id">Doctor</label>
            <select name="doctor_id" id="doctor_id" class="form-control" required>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialty }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="appointment_date">Appointment Date</label>
            <input type="datetime-local" name="appointment_date" id="appointment_date" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="reason">Reason</label>
            <textarea name="reason" id="reason" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Book Appointment</button>
    </form>
</div>
@endsection