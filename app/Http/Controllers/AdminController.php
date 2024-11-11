<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LunchReservation;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $summaries = LunchReservation::select(
            'start_date',
            'lunch_type',
            DB::raw('count(*) as count')
        )
            ->groupBy('start_date', 'lunch_type')
            ->orderBy('start_date')
            ->get()
            ->groupBy('start_date')
            ->map(function ($items) {
                return $items->pluck('count', 'lunch_type');
            });

        return Inertia::render('Admin/Index', [
            'summaries' => $summaries,
            'lunchTypes' => LunchReservation::LUNCH_TYPES
        ]);
    }
}
