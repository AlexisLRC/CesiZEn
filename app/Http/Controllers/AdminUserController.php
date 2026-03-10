<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminUserController extends Controller
{
    /**
     * Liste tous les utilisateurs avec filtres et tri.
     */
    public function index(Request $request)
    {
        $query = User::where('id', '!=', auth()->id());

        // Filtre par Nom ou Email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtre par Rôle
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filtre par Statut (bloqué ou non)
        if ($request->filled('status')) {
            $isBlocked = $request->status === 'blocked';
            $query->where('is_blocked', $isBlocked);
        }

        // Tri
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');
        
        $allowedSorts = ['name', 'email', 'role', 'is_blocked', 'created_at'];
        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction);
        } else {
            $query->orderBy('name', 'asc');
        }

        $users = $query->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Bloquer ou débloquer un utilisateur.
     */
    public function toggleBlock(User $user)
    {
        $user->is_blocked = !$user->is_blocked;
        $user->save();

        $status = $user->is_blocked ? 'bloqué' : 'débloqué';
        return back()->with('success', "L'utilisateur {$user->name} a été {$status}.");
    }

    /**
     * Supprimer un utilisateur.
     */
    public function destroy(User $user)
    {
        // Supprimer l'avatar si existant
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return back()->with('success', "L'utilisateur {$user->name} a été supprimé.");
    }
}
