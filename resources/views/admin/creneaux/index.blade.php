@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestion des créneaux horaires</h1>
    <a href="{{ route('admin.creneaux.create') }}" class="btn btn-success mb-3">Ajouter un créneau</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Médecin</th>
                <th>Date</th>
                <th>Heure de début</th>
                <th>Heure de fin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->doctor->name }}</td>
                    <td>{{ $schedule->date }}</td>
                    <td>{{ $schedule->start_time }}</td>
                    <td>{{ $schedule->end_time }}</td>
                    <td>
                        <a href="{{ route('admin.creneaux.edit', $schedule->id) }}" class="btn btn-warning btn-sm">Éditer</a>
                        <form action="{{ route('admin.creneaux.destroy', $schedule->id) }}" method="POST" class="d-inline">
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