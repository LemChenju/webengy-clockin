<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function showProfile()
    {
        return view('profile');
    }

    public function showPasswordChangeForm()
    {
        return view('password_change');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
'old_password' => 'required',
'new_password' => 'required|string|min:8|confirmed',
]);

if ($validator->fails()) {
return back()->withErrors($validator);
}

$user = Auth::user();

if (!Hash::check($request->old_password, $user->password)) {
return back()->withErrors(['old_password' => 'Das alte Passwort ist falsch.']);
}

$user->password = Hash::make($request->new_password);
$user->save();

return redirect()->route('profile')->with('success', 'Passwort erfolgreich geändert.');
}
}
