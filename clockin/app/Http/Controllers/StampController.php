<?php
namespace App\Http\Controllers;

use App\Models\Stamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StampController extends Controller
{
    public function stampIn(Request $request)
    {
        $user = auth()->id();
        DB::table('stamps')->insert(
            array(
                'user_id'     =>   $user,
                'stamped_in_at'   =>   now()
            )
        );

        return back()->with('status', 'Stamped in successfully!');
    }

    public function stampOut(Request $request)
    {

        $user = auth()->id();
        $stamp = Stamp::where('user_id', $user)->latest()->first();
        if ($stamp && is_null($stamp->stamped_out_at)) {
            // Update the existing record with 'stamped_out_at' time
            $stamp->update(['stamped_out_at' => now()]);
        } else {
            // Insert a new record if no open stamp exists
            DB::table('stamps')->insert([
                'user_id'       => $user,
                'stamped_in_at' => now(), // Assuming you're creating a new in-time
            ]);
        }


        return back()->with('status', 'Stamped out successfully!');
    }
}
