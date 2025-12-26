<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a list of the authenticated user's bookings
     */
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())->get();

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show booking creation form
     */
    public function create()
    {
        return view('bookings.create');
    }

    /**
     * Store a new booking
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|in:Consultation,System Maintenance,Technical Support,Security Audit',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
        ]);

        // ✅ Create booking via relationship (secure)
        $booking = Auth::user()->bookings()->create([
            'service_name' => $request->service_name,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
        ]);

        // 🔐 Audit log
        AuditLog::create([
            'user_id'   => Auth::id(),
            'action'    => 'CREATE',
            'entity'    => 'booking',
            'entity_id' => $booking->id,
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    /**
     * Show edit form (owner only)
     */
    public function edit(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('bookings.edit', compact('booking'));
    }

    /**
     * Update booking (owner only)
     */
    public function update(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'service_name' => 'required|in:Consultation,System Maintenance,Technical Support,Security Audit',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
        ]);

        $booking->update([
            'service_name' => $request->service_name,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
        ]);

        // 🔐 Audit log
        AuditLog::create([
            'user_id'   => Auth::id(),
            'action'    => 'UPDATE',
            'entity'    => 'booking',
            'entity_id' => $booking->id,
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    /**
     * Delete booking (owner only)
     */
    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // 🔐 Audit log BEFORE delete
        AuditLog::create([
            'user_id'   => Auth::id(),
            'action'    => 'DELETE',
            'entity'    => 'booking',
            'entity_id' => $booking->id,
        ]);

        $booking->delete();

        return redirect()->route('bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }
}
