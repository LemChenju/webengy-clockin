<?php

namespace App\Http\Controllers;

use App\Models\Stamp;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    /**
     * @throws \Exception
     */
    public function generatePDF(Request $request)
    {
        $userId = Auth::id();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Retrieve the stamps using the newly created function.
        $stamps = $this->getStampsForUser($userId, $startDate, $endDate);

        // If the result is a response (like an error), return it immediately.
        if ($stamps instanceof \Illuminate\Http\JsonResponse) {
            return $stamps;
        }

        // Generate the PDF as before.
        $pdf = Pdf::loadView('pdf.stamp-history', compact('stamps', 'startDate', 'endDate'));

        return $pdf->stream('stempelhistorie.pdf');
    }


    public function getStampsForUser($userId, $startDate, $endDate)
    {
        // Ensure startDate and endDate are valid dates before proceeding.
        if (!$startDate || !$endDate) {
            return response()->json(['error' => 'Invalid date range provided'], 400);
        }

        // Query the Stamp records for the given user within the date range.
        $query = Stamp::where('user_id', $userId);

        // Check if the query was successful in returning a builder instance.
        if (is_null($query)) {
            throw new \Exception('Failed to create a query builder instance.');
        }

        // Apply the whereBetween filters to the query.
        $stamps = $query->whereBetween('stamped_in_at', [$startDate, $endDate])
            ->orWhereBetween('stamped_out_at', [$startDate, $endDate])
            ->get();
        return $stamps;
    }
}
