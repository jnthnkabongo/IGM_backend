<?php

namespace App\Http\Controllers;

use App\Models\Minerai;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Créer une nouvelle instance du contrôleur
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Afficher le dashboard
     */
    public function index()
    {
       // $user = Auth::user();
        
        // Statistiques exemple pour le dashboard
        $stats = [
            'total_users' => 150,
            'total_orders' => 1240,
            'total_revenue' => 45000,
            'growth_rate' => 12.5,
        ];

        return view('dashboard.index', compact( 'stats'));
    }

    /**
     * Afficher le profil utilisateur
     */
    public function profile()
    {
        $user = Auth::user();
        return view('dashboard.profile', compact('user'));
    }

    /**
     * Mettre à jour le profil utilisateur
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::find($user->id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);

        return back()->with('success', 'Profil mis à jour avec succès !');
    }

    /*** CRUD utilisateurs */
    public function utilisateurs()
    {
        $users = User::with('role')->get();
        $roles = Role::orderBy('nom')->get();
        return view('dashboard.utilisateurs', compact('users', 'roles'));
    }
    //*** Creation utilisateur ***//
    public function createUtilisateur()
    {
        return view('dashboard.create-utilisateur');
    }
    //*** Sauvegarde utilisateur ***//
    public function saveUtilisateur(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('dashboard.utilisateurs')->with('success', 'Utilisateur créé avec succès !');
    }

    public function editUtilisateur($id)
    {
        $user = User::find($id);
        return view('dashboard.edit-utilisateur', compact('user'));
    }
    ///*** Modification utilisateur ***//
    public function updateUtilisateur(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8',
        ]);

        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return redirect()->route('dashboard.utilisateurs')->with('success', 'Utilisateur mis à jour avec succès !');
    }
    //*** Suppression utilisateur ***//
    public function deleteUtilisateur($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('dashboard.utilisateurs')->with('success', 'Utilisateur supprimé avec succès !');
    }


    ///*** CRUD roles ***//
    public function roles()
    {
        $roles = Role::paginate(10);
        return view('dashboard.roles', compact('roles'));
    }
    ///*** Creation role ***//
    public function createRole()
    {
        return view('dashboard.create-role');
    }
    ///*** Sauvegarde role ***//
    public function saveRole(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        Role::create([
            'nom' => $request->nom,
        ]);

        return redirect()->route('dashboard.roles')->with('success', 'Role créé avec succès !');
    }
    ///*** Modification role ***//
    public function editRole($id)
    {
        $role = Role::find($id);
        return view('dashboard.edit-role', compact('role'));
    }
    ///*** Sauvegarde role ***//
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $role = Role::find($id);
        $role->update([
            'nom' => $request->nom,
        ]);

        return redirect()->route('dashboard.roles')->with('success', 'Role mis à jour avec succès !');
    }
    ///*** Suppression role ***//
    public function deleteRole($id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('dashboard.roles')->with('success', 'Role supprimé avec succès !');
    }

    ///*** CRUD des mines */
    public function mines()
    {
        $mines = Minerai::paginate(10);
        return view('dashboard.mines', compact('mines'));
    }
    /// Sauvegarde mine
    public function saveMine(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'unite' => 'required|string|max:255',
            'prix_reference' => 'required|numeric',
        ]);

        $code = 'MIN-' . \Illuminate\Support\Str::random(20);

        Minerai::create([
            'code' => $code,
            'nom' => $request->nom,
            'unite' => $request->unite,
            'prix_reference' => $request->prix_reference,
        ]);

        return redirect()->route('dashboard.mines')->with('success', 'Mine créée avec succès !');
    }
    /// Modification mine
    public function editMine($id)
    {
        $mine = Minerai::find($id);
        return view('dashboard.edit-mine', compact('mine'));
    }
    /// Sauvegarde mine
    public function updateMine(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'unite' => 'required|string|max:255',
            'prix_reference' => 'required|numeric',
        ]);

        $mine = Minerai::find($id);
        $mine->update([
            'nom' => $request->nom,
            'unite' => $request->unite,
            'prix_reference' => $request->prix_reference,
        ]);

        return redirect()->route('dashboard.mines')->with('success', 'Mine mise à jour avec succès !');
    }
    /// Suppression mine
    public function deleteMine($id)
    {
        $mine = Minerai::find($id);
        $mine->delete();
        return redirect()->route('dashboard.mines')->with('success', 'Mine supprimée avec succès !');
    }
}
