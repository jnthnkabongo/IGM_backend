<?php

namespace App\Http\Controllers;
use App\Models\LogsActivite;
use App\Models\Minerai;
use App\Models\SiteMinier;
use App\Models\Concession;
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
            $user = Auth::user();

            if ($user->role && $user->role->nom !== 'agent terrain' && $user->role->nom !== 'agent frontiere' && $user->role->nom !== 'client') {
                Auth::logout();
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

        $role = $user->role ? $user->role->nom : null;
        $data = [];

        switch($role) {
            case 'agent terrain':
                // Agent terrain peut voir les minerais et sites
                $data = [
                    'minerais' => Minerai::with('siteMinier')->get(),
                    'sites' => SiteMinier::with('concession')->get(),
                ];
                break;
            case 'agent frontiere':
                // Agent frontière peut voir les concessions
                $data = [
                    'nombre_verifications' => Minerai::count(),
                    'concessions' => Concession::with('sitesMiniers')->count(),
                    'sites_miniers' => SiteMinier::with('concession')->count(),
                ];
                break;
            case 'client':
                // Client peut voir les minerais disponibles
                $data = [
                    'minerais' => Minerai::where('etat_minerai', 'Disponible')->with('siteMinier')->get(),
                ];
                break;
            default:
                // Admin ou autres rôles peuvent tout voir
                $data = [
                    'minerais' => Minerai::with('siteMinier')->get(),
                    'sites' => SiteMinier::with('concession', 'responsable')->get(),
                    'concessions' => Concession::with('sitesMiniers')->get(),
                ];
                break;
        }

        return response()->json([
            'success' => true,
            'message' => 'Dashboard API',
            //'user' => $user,
            'role' => $role,
            'data' => $data,
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
