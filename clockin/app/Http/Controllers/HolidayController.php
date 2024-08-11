<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket;
class HolidayController extends Controller 
{
    public function store(Request $request)
    {
        // Validierung
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'reason' => 'required|string|max:255',
        ]);

        // Ticket speichern
        $userId = auth()->id();

        DB::table('tickets')->insert(
            array(
                'user_id'     =>   $userId,
                'start_date'   =>   $startDate,
                'end_date'  =>  $endDate,
                'reason'    =>  $reason
            )
        );

        // Erfolgsnachricht und Weiterleitung
        return redirect()->back()->with('success', 'Der Urlaub wurde erfolgreich beantragt.');
    }
}
