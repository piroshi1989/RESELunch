<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\LunchReservation;
use Illuminate\Support\Facades\Auth;

class LunchReservationController extends Controller
{
    public function index()
    {
        $reservations = LunchReservation::where('user_id', Auth::id())
            ->get()
            ->map(function($reservation) {
                return [
                    'id' => $reservation->id,
                    'title' => LunchReservation::LUNCH_TYPES[$reservation->lunch_type],
                    'start' => $reservation->start_date,
                    'end' => $reservation->end_date,
                    'color' => LunchReservation::LUNCH_COLORS[$reservation->lunch_type],
                    'lunch_type' => $reservation->lunch_type
                ];
            });

        return Inertia::render('Reservations/Index', [
            'reservations' => $reservations,
            'lunchTypes' => LunchReservation::LUNCH_TYPES
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lunch_type' => 'required|integer|between:1,4',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $reservation = LunchReservation::create([
            'user_id' => Auth::id(),
            'lunch_type' => $validated['lunch_type'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date']
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'lunch_type' => 'required|integer|between:1,4',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);
        $lunchReservation = LunchReservation::findOrFail($id);
        $lunchReservation->lunch_type = $request->lunch_type;
        $lunchReservation->start_date = $request->start_date;
        $lunchReservation->end_date = $request->end_date;
        $lunchReservation->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $lunchReservation = LunchReservation::findOrFail($id);
        $lunchReservation->delete();
        return redirect()->back();
    }
}
