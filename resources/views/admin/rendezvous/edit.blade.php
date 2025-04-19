@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Éditer le rendez-vous</h1>
    <form action="{{ route('admin.rendezvous.update', $appointment->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="patient_id">Patient</label>
        <select name="patient_id" id="patient_id" class="form-control" required>
            @foreach ($patients as $patient)
                <option value="{{ $patient->id }}" {{ $appointment->patient_id == $patient->id ? 'selected' : '' }}>{{ $patient->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="doctor_id">Médecin</label>
        <select name="doctor_id" id="doctor_id" class="form-control" required>
            @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}" {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="appointment_date">Date et heure</label>
        <input type="datetime-local" name="appointment_date" id="appointment_date" class="form-control" value="{{ $appointment->appointment_date }}" required>
    </div>
    <div class="form-group">
        <label for="reason">Motif</label>
        <input type="text" name="reason" id="reason" class="form-control" value="{{ $appointment->reason }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Mettre à jour</button>
</form>
</div>
@endsection