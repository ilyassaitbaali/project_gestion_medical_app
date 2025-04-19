@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Gestion des rendez-vous</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Médecin</th>
                <th>Date et heure</th>
                <th>Motif</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->name }}</td>
                    <td>{{ $appointment->doctor->name }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>{{ $appointment->reason }}</td>
                    <td>
                        <a href="{{ route('admin.rendezvous.edit', $appointment->id) }}" class="btn btn-warning btn-sm">Éditer</a>
                        <form action="{{ route('admin.rendezvous.destroy', $appointment->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection