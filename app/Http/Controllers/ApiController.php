<?php

namespace App\Http\Controllers;
use App\Models\LogsActivite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    protected function activityApi($action, $tableConcernee, $referenceId)
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

    // Ajouter d'autres méthodes spécifiques à l'API ici
    public function loginApi(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->role && $user->role->nom !== 'agent terrain' && $user->role->nom !== 'agent frontiere' && $user->role->nom !== 'client') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return response()->json([
                    'success' => false,
                    'message' => 'Seuls les agents terrain, frontière et clients peuvent se connecter.',
                ], 403);
            }
            
            $token = $user->createToken('auth-token')->plainTextToken;
            return response()->json([
                'success' => true,
                'message' => 'Connexion réussie',
                'user' => $user,
                'token' => $token,
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Identifiants invalides',
        ], 401);
    }

    public function dashboardApi()
    {
        $user = Auth::user();
        if(!$user){
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non authentifié',
            ], 401);
        }
        return response()->json([
            'success' => true,
            'message' => 'Dashboard API',
            'user' => $user,
        ]);
    }
    
    // Déconnexion API
    public function logoutApi(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return response()->json([
            'success' => true,
            'message' => 'Déconnexion réussie',
        ]);
    }

}
