<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Tableau de bord
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalAppointments = Appointment::count();
        $totalCreneaux = Schedule::count();

        // Récupérer les 10 derniers rendez-vous avec les relations patient et doctor
        $appointments = Appointment::with(['patient', 'doctor'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('totalUsers', 'totalAppointments', 'totalCreneaux', 'appointments'));
    }

    // Gestion des utilisateurs
    public function indexUsers()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:0,1,2', 
        ]);

        // Créer l'utilisateur
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => $validatedData['role'],
        ]);

        // Rediriger avec un message de succès
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:0,1,2',
        ]);

        // Mettre à jour l'utilisateur
        $user->update($validatedData);

        
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroyUser(User $user)
    {
        // Supprimer l'utilisateur
        $user->delete();

        
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

    // Gestion des créneaux horaires
    public function indexCreneaux()
    {
        $schedules = Schedule::with('doctor')->get();
        return view('admin.creneaux.index', compact('schedules'));
    }

    public function createCreneau()
    {
        $doctors = User::where('role', 1)->get(); 
        return view('admin.creneaux.create', compact('doctors'));
    }

    public function storeCreneau(Request $request)
    {
        
        $validatedData = $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Créer le créneau horaire
        Schedule::create($validatedData);

        
        return redirect()->route('admin.creneaux.index')->with('success', 'Créneau horaire créé avec succès.');
    }

    public function editCreneau(Schedule $schedule)
    {
        $doctors = User::where('role', 1)->get();
        return view('admin.creneaux.edit', compact('schedule', 'doctors'));
    }

    public function updateCreneau(Request $request, Schedule $schedule)
    {
        
        $validatedData = $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_available' => 'required|boolean',
        ]);
    
        // Mettre à jour le créneau horaire
        $schedule->update($validatedData);
    
       
        return redirect()->route('admin.creneaux.index')->with('success', 'Créneau horaire mis à jour avec succès.');
    }

    public function destroyCreneau(Schedule $schedule)
    {
        // Supprimer le créneau horaire
        $schedule->delete();

        
        return redirect()->route('admin.creneaux.index')->with('success', 'Créneau horaire supprimé avec succès.');
    }

    // Gestion des rendez-vous
    public function indexRendezVous()
    {
        $appointments = Appointment::with(['patient', 'doctor'])->get();
        return view('admin.rendezvous.index', compact('appointments'));
    }

    public function editRendezVous(Appointment $appointment)
    {
        $patients = User::where('role', 2)->get();
        $doctors = User::where('role', 1)->get();
        return view('admin.rendezvous.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function updateRendezVous(Request $request, Appointment $appointment)
    {
        
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'reason' => 'required|string|max:255',
        ]);

        // Mettre à jour le rendez-vous
        $appointment->update($validatedData);

        
        return redirect()->route('admin.rendezvous.index')->with('success', 'Rendez-vous mis à jour avec succès.');
    }

    public function destroyRendezVous(Appointment $appointment)
    {
        // Supprimer le rendez-vous
        $appointment->delete();

        
        return redirect()->route('admin.rendezvous.index')->with('success', 'Rendez-vous supprimé avec succès.');
    }
}