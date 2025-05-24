<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('type')->orderBy('nom')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:Administrateur,Voyageur,Sous-Traitant',
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'contact_telephone' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date',
            'commune_residence' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'type' => $request->type,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'contact_telephone' => $request->contact_telephone,
            'whatsapp' => $request->whatsapp,
            'date_naissance' => $request->date_naissance,
            'commune_residence' => $request->commune_residence,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? $request->type,
        ]);

        return redirect()->route('users.show', $user)
            ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('reservations');
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'type' => 'required|in:Administrateur,Voyageur,Sous-Traitant',
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'contact_telephone' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date',
            'commune_residence' => 'nullable|string|max:255',
            'role' => 'nullable|string|max:255',
        ]);

        $data = $request->except('password');
        
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.show', $user)
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
}