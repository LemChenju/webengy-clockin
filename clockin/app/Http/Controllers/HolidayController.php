<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['startDate']) && isset($_POST['endDate']) && isset($_POST['reason'])) {
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            $reason = $_POST['reason'];

            $userId = auth()->id();

            DB::table('stamps')->insert(
                array(
                    'user_id'     =>   $userId,
                    'start_date'   =>   $startDate,
                    'end_date'  =>  $endDate,
                    'reason'    =>  $reason
                )
            );

            $successMessage = 'Urlaub beantragt!';
        }

        // Erfolgsnachricht und Weiterleitung
        return redirect()->back()->with('success', 'Der Urlaub wurde erfolgreich beantragt.');
    }
}
