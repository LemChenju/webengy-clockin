<?php
namespace App\Http\Controllers;
use App\Models\Stamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PDF; // Make sure to include the appropriate PDF library


class HistoryController extends Controller
{
    public function generatePDF(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Fetch data from the database based on the date range
        $data = YourModel::whereBetween('created_at', [$startDate, $endDate])->get();

        // Generate PDF using the data
        $pdf = PDF::loadView('your_view', compact('data'));

        // Return the generated PDF to the browser
        return $pdf->download('report.pdf');
    }

        public function stampIn(Request $request)
        {
            Log::info('Stamp In Attempt');

            if (Auth::check()) {
                $user = Auth::user();
                Log::info('Stamp In Attempt', ['user_id' => $user->id]);
                $stamp = new Stamp();
                $stamp->user_id = $user->id;
                $stamp->stamped_in_at = now();
                $stamp->save();


                return back()->with('status', 'Stamped in successfully!');
            }
            return redirect('login')->withError('You do not have Access');

        }

        public function stampOut(Request $request)
    {

        if (Auth::check()) {
            $userId = Auth::id();
            Log::info('Stamp Out Attempt', ['user_id' => $userId]);
            $stamp = Stamp::where('user_id', $userId)->latest()->first();
            $stamp->stamped_out_at = now();
            $stamp->save();

        return back()->with('status', 'Stamped out successfully!');
        }
        return redirect('login')->withError('You do not have Access');

    }
    public function clockinouthistory(Request $request){
        if(Auth::check()){
            return view('clockinouthistory');
        }
        return redirect('login')->withError('You do not have Access');
    }

}
