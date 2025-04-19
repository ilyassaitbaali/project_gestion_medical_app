<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\AppointmentConfirmation;
use App\Notifications\AppointmentReminder;

class AppointmentController extends Controller
{
    // View Appointment History
    public function index()
    {
        $appointments = Appointment::where('patient_id', auth()->id())->get();
        return view('appointments.index', compact('appointments'));
    }

    // Show Appointment Booking Form
    public function create()
    {
        $doctors = User::where('role', 1)->get(); 
        return view('appointments.create', compact('doctors'));
    }

    // Book a New Appointment
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'reason' => 'required|string|max:255',
        ]);

        $appointment = Appointment::create([
            'patient_id' => auth()->id(),
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'reason' => $request->reason,
        ]);

        // Send confirmation notification
        //$appointment->patient->notify(new AppointmentConfirmation($appointment));

        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully.');
    }

    // Cancel an Appointment
    public function destroy(Appointment $appointment)
    {
        if ($appointment->patient_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment canceled successfully.');
    }
}