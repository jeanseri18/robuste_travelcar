<?php

namespace App\Http\Controllers;

use App\Models\SousTraitant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SousTraitantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $soustraitants = SousTraitant::with('user')->orderBy('created_at', 'desc')->get();
        return view('soustraitants.index', compact('soustraitants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('soustraitants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:personne_physique,personne_morale',
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'contact_telephone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'whatsapp' => 'nullable|string|max:20',
            'nom_commercial' => 'nullable|string|max:255',
            'forme_juridique' => 'nullable|string|max:255',
            'capital' => 'nullable|numeric|min:0',
            'rccm' => 'nullable|string|max:255',
            'compte_contribuable' => 'nullable|string|max:255',
            'adresse_geographique' => 'nullable|string|max:255',
            'adresse_postale' => 'nullable|string|max:255',
            'telephone_fixe' => 'nullable|string|max:20',
            'telephone_mobile' => 'nullable|string|max:20',
            'commune_activite' => 'required|string|max:255',
            'montant_cautionnement' => 'nullable|numeric|min:0',
        ]);

        // Créer l'utilisateur
        $user = User::create([
            'type' => 'Sous-Traitant',
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'contact_telephone' => $request->contact_telephone,
            'whatsapp' => $request->whatsapp,
            'password' => Hash::make($request->password),
            'role' => 'Sous-Traitant',
        ]);

        // Créer le sous-traitant
        $soustraitant = SousTraitant::create([
            'user_id' => $user->id,
            'type' => $request->type,
            'nom_commercial' => $request->nom_commercial,
            'forme_juridique' => $request->forme_juridique,
            'capital' => $request->capital,
            'rccm' => $request->rccm,
            'compte_contribuable' => $request->compte_contribuable,
            'adresse_geographique' => $request->adresse_geographique,
            'adresse_postale' => $request->adresse_postale,
            'telephone_fixe' => $request->telephone_fixe,
            'telephone_mobile' => $request->telephone_mobile ?? $request->contact_telephone,
            'taux_commission' => $request->taux_commission ?? 1.00,
            'commune_activite' => $request->commune_activite,
            'montant_cautionnement' => $request->montant_cautionnement,
        ]);

        return redirect()->route('soustraitants.show', $soustraitant)
            ->with('success', 'Sous-traitant créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SousTraitant $soustraitant)
    {
        $soustraitant->load(['user', 'lignes.societe']);
        return view('soustraitants.show', compact('soustraitant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SousTraitant $soustraitant)
    {
        $soustraitant->load('user');
        return view('soustraitants.edit', compact('soustraitant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SousTraitant $soustraitant)
    {
        $request->validate([
            'type' => 'required|in:personne_physique,personne_morale',
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $soustraitant->user_id,
            'contact_telephone' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'nom_commercial' => 'nullable|string|max:255',
            'forme_juridique' => 'nullable|string|max:255',
            'capital' => 'nullable|numeric|min:0',
            'rccm' => 'nullable|string|max:255',
            'compte_contribuable' => 'nullable|string|max:255',
            'adresse_geographique' => 'nullable|string|max:255',
            'adresse_postale' => 'nullable|string|max:255',
            'telephone_fixe' => 'nullable|string|max:20',
            'telephone_mobile' => 'nullable|string|max:20',
            'taux_commission' => 'nullable|numeric|between:0,100',
            'commune_activite' => 'required|string|max:255',
            'montant_cautionnement' => 'nullable|numeric|min:0',
            'est_actif' => 'boolean',
        ]);

        // Mettre à jour l'utilisateur
        $soustraitant->user->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'contact_telephone' => $request->contact_telephone,
            'whatsapp' => $request->whatsapp,
        ]);

        // Mettre à jour le sous-traitant
        $soustraitant->update([
            'type' => $request->type,
            'nom_commercial' => $request->nom_commercial,
            'forme_juridique' => $request->forme_juridique,
            'capital' => $request->capital,
            'rccm' => $request->rccm,
            'compte_contribuable' => $request->compte_contribuable,
            'adresse_geographique' => $request->adresse_geographique,
            'adresse_postale' => $request->adresse_postale,
            'telephone_fixe' => $request->telephone_fixe,
            'telephone_mobile' => $request->telephone_mobile,
            'taux_commission' => $request->taux_commission,
            'commune_activite' => $request->commune_activite,
            'montant_cautionnement' => $request->montant_cautionnement,
            'est_actif' => $request->est_actif ?? false,
        ]);

        return redirect()->route('soustraitants.show', $soustraitant)
            ->with('success', 'Sous-traitant mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SousTraitant $soustraitant)
    {
        // Supprimer l'utilisateur (qui supprimera aussi le sous-traitant)
        $soustraitant->user->delete();

        return redirect()->route('soustraitants.index')
            ->with('success', 'Sous-traitant supprimé avec succès.');
    }
}