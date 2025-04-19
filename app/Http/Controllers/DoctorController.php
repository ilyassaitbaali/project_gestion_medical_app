<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Schedule;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    
    public function schedules()
    {
        $schedules = Schedule::where('doctor_id', auth()->id())->get();
        return view('doctor.schedules', compact('schedules'));
    }

    public function storeSchedule(Request $request)
    {
        // Validate the request
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        
        Schedule::create([
            'doctor_id' => auth()->id(),
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('doctor.schedules')->with('success', 'Schedule created successfully.');
    }

    // View scheduled appointments
    public function appointments()
    {
        $appointments = Appointment::where('doctor_id', auth()->id())->get();
        return view('doctor.appointments', compact('appointments'));
    }

    // Cancel an appointment
    public function cancelAppointment(Appointment $appointment)
    {
        if ($appointment->doctor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $appointment->delete();
        return redirect()->route('doctor.appointments')->with('success', 'Appointment canceled successfully.');
    }

    // Update an appointment
    public function updateAppointment(Request $request, Appointment $appointment)
    {
        
        if ($appointment->doctor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        
        $request->validate([
            'appointment_date' => 'required|date',
            'reason' => 'required|string|max:255',
        ]);

        // Update the appointment
        $appointment->update([
            'appointment_date' => $request->appointment_date,
            'reason' => $request->reason,
        ]);

        return redirect()->route('doctor.appointments')->with('success', 'Appointment updated successfully.');
    }
}
