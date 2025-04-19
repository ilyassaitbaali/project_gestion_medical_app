@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tableau de bord</h1>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Gérer les utilisateurs</a>
                    <p class="card-text">{{ $totalUsers }} utilisateurs</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <a href="{{ route('admin.rendezvous.index') }}" class="btn btn-success">Gérer les rendez-vous</a>
                    <p class="card-text">{{ $totalAppointments }} rendez-vous</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                <a href="{{ route('admin.creneaux.index') }}" class="btn btn-info">Gérer les créneaux</a>
                    <p class="card-text">{{ $totalCreneaux }} créneaux</p>
                </div>
            </div>
        </div>
    </div>

    <h2>Derniers rendez-vous</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Médecin</th>
                <th>Date et heure</th>
                <th>Motif</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->name }}</td>
                    <td>{{ $appointment->doctor->name }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>{{ $appointment->reason }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection