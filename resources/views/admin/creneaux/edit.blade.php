@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Éditer le créneau</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.creneaux.update', $schedule->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="doctor_id">Médecin</label>
            <select name="doctor_id" id="doctor_id" class="form-control" required>
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ $schedule->doctor_id == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ $schedule->date }}" required>
        </div>
        <div class="form-group">
            <label for="start_time">Heure de début</label>
            <input type="time" name="start_time" id="start_time" class="form-control" value="{{ $schedule->start_time }}" required>
        </div>
        <div class="form-group">
            <label for="end_time">Heure de fin</label>
            <input type="time" name="end_time" id="end_time" class="form-control" value="{{ $schedule->end_time }}" required>
        </div>
        <div class="form-group">
            <label for="is_available">Disponible</label>
            <select name="is_available" id="is_available" class="form-control" required>
                <option value="1" {{ $schedule->is_available ? 'selected' : '' }}>Oui</option>
                <option value="0" {{ !$schedule->is_available ? 'selected' : '' }}>Non</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection