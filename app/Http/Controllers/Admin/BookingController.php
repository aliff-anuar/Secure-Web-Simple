<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display all bookings (Admin only)
     */
    public function index()
    {
        // 🔐 Enforce admin-only access
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        // Load bookings with related user
        $bookings = Booking::with('user')->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Delete a booking (Admin only)
     */
    public function destroy(Booking $booking)
    {
        // 🔐 Enforce admin-only access
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        // 🔐 Audit log BEFORE delete
        AuditLog::create([
            'user_id'   => Auth::id(),
            'action'    => 'ADMIN_DELETE',
            'entity'    => 'booking',
            'entity_id' => $booking->id,
        ]);

        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted by admin');
    }
}
