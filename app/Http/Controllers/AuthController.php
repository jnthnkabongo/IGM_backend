<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\LogsActivite;

class AuthController extends Controller
{
    /**
     * Afficher la page de connexion
     */
    public function activity(){

    }

    /**
     * Enregistrer l'activité de l'utilisateur
     */
    protected function logActivity($action, $tableConcernee, $referenceId)
    {
        if (Auth::check()) {
            LogsActivite::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'table_concernee' => $tableConcernee,
                'reference_id' => $referenceId,
            ]);
        }
    }

    public function showLoginForm()
    {
        // User::create([
        //     'name' => 'Admin',
        //     'email' => 'jonathn@gmail.com',
        //     'role_id' => 1,
        //     'password' => Hash::make('12345678'),
        // ]);
        return view('auth.login');
    }

    /**
     * Traiter la tentative de connexion
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->role && $user->role->nom !== 'administrateur') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return back()->withErrors([
                    'email' => 'Seuls les administrateurs peuvent se connecter.',
                ])->withInput($request->only('email'));
            }
            
            return redirect()->intended('dashboard')
                ->with('success', 'Connexion réussie !');
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->withInput($request->only('email'));
    }

    /**
     * Déconnecter l'utilisateur
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
