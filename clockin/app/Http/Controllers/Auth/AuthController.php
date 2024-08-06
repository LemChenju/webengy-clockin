<?php
namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller{
    public function index(): View {
        return view('Auth.login');
    }

    public function registration(): View {
        return view ('Auth.registration');
    }

    public function loginAction(Request $request): RedirectResponse {
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        $credentials =$request->only('email','password');
        if (Auth::attempt($credentials)){
            return redirect()->intended('dashboard')->withSuccess('You have Successfully logged in');
        }
        return redirect('login')->withError('Invalid Credentials');
    }

    public function registrationAction(Request $request): RedirectResponse {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:8'
        ]);
        $data = $request->all();
        $user = $this->create($data);

        Auth::login($user);

        return redirect('dashboard')->withSuccess('Successfull Login');
    }
    public function dashboard(){
        if(Auth::check()){
            return view('dashboard');
        }
        return redirect('login')->withError('You do not have Access');
    }
    public function create(array $data){
        return User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password'])
        ]);
    }
    public function logout(): RedirectResponse{
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
}
