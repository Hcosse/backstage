<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Inscription (Web)
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'name'     => 'required|string|max:255',
           'email'    => 'required|string|email|max:255|unique:users',
           'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
           return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $user = User::create([
           'name'     => $request->name,
           'email'    => $request->email,
           'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Inscription réussie !');
    }

    // Connexion (Web)
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
           $request->session()->regenerate();
           return redirect()->route('dashboard')->with('success', 'Connexion réussie !');
        }

        return redirect()->back()
                         ->withErrors(['email' => 'Identifiants invalides'])
                         ->withInput();
    }

    // Déconnexion (Web)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('welcome')->with('success', 'Déconnexion réussie !');
    }
}
