@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Gestion des utilisateurs</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-success mb-3">Ajouter un utilisateur</a>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Retour au tableau de bord</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->role == 0)
                            Admin
                        @elseif ($user->role == 1)
                            Médecin
                        @else
                            Patient
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Éditer</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
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