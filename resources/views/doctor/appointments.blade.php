@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Scheduled Appointments</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Date</th>
                <th>Reason</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->name }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>{{ $appointment->reason }}</td>
                    <td>
                        <!-- Button to trigger the edit modal -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editAppointmentModal{{ $appointment->id }}">
                            Edit
                        </button>

                        <!-- Cancel Appointment Form -->
                        <form action="{{ route('doctor.appointments.cancel', $appointment) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Appointment Modal -->
                <div class="modal fade" id="editAppointmentModal{{ $appointment->id }}" tabindex="-1" aria-labelledby="editAppointmentModalLabel{{ $appointment->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editAppointmentModalLabel{{ $appointment->id }}">Edit Appointment</h5>
                                <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#editAppointmentModal{{ $appointment->id }}" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('doctor.appointments.update', $appointment) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group mb-3">
                                        <label for="appointment_date">Appointment Date</label>
                                        <input type="datetime-local" name="appointment_date" id="appointment_date" class="form-control" value="{{ $appointment->appointment_date }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="reason">Reason</label>
                                        <textarea name="reason" id="reason" class="form-control" required>{{ $appointment->reason }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update Appointment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection