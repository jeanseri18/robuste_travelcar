<?php

namespace App\Http\Controllers;

use App\Models\Societe;
use App\Models\Gare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SocieteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $societes = Societe::orderBy('nom_commercial')->get();
        return view('societes.index', compact('societes'));
    }

    /**
     * Display a listing of national societes.
     */
    public function indexNational()
    {
        $societes = Societe::national()->orderBy('nom_commercial')->get();
        return view('societes.national', compact('societes'));
    }

    /**
     * Display a listing of sous-regional societes.
     */
    public function indexSousRegional()
    {
        $societes = Societe::sousRegional()->orderBy('nom_commercial')->get();
        return view('societes.sousregional', compact('societes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('societes.create');
    }

    /**
     * Show the form for creating a new national societe.
     */
    public function createNational()
    {
        return view('societes.create-national');
    }

    /**
     * Show the form for creating a new sous-regional societe.
     */
    public function createSousRegional()
    {
        return view('societes.create-sousregional');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_commercial' => 'required|string|max:255',
            'type' => 'required|in:national,sousregional',
            'forme_juridique' => 'nullable|string|max:255',
            'siege_social' => 'nullable|string|max:255',
            'date_creation' => 'nullable|date',
            'capital' => 'nullable|numeric',
            'rccm' => 'nullable|string|max:255',
            'compte_contribuable' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'responsable_marketing' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        $societe = Societe::create($data);

        return redirect()->route('societes.show', $societe)
            ->with('success', 'Société créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Societe $societe)
    {
        return view('societes.show', compact('societe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Societe $societe)
    {
        return view('societes.edit', compact('societe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Societe $societe)
    {
        $request->validate([
            'nom_commercial' => 'required|string|max:255',
            'type' => 'required|in:national,sousregional',
            'forme_juridique' => 'nullable|string|max:255',
            'siege_social' => 'nullable|string|max:255',
            'date_creation' => 'nullable|date',
            'capital' => 'nullable|numeric',
            'rccm' => 'nullable|string|max:255',
            'compte_contribuable' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'responsable_marketing' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['logo', 'remove_logo']);

        // Gérer la suppression du logo
        if ($request->has('remove_logo') && $request->remove_logo == '1') {
            if ($societe->logo) {
                Storage::disk('public')->delete($societe->logo);
            }
            $data['logo'] = null;
        }
        // Gérer l'upload d'un nouveau logo
        elseif ($request->hasFile('logo')) {
            // Supprimer l'ancien logo s'il existe
            if ($societe->logo) {
                Storage::disk('public')->delete($societe->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        $societe->update($data);

        return redirect()->route('societes.show', $societe)
            ->with('success', 'Société mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Societe $societe)
    {
        // Supprimer le logo s'il existe
        if ($societe->logo) {
            Storage::disk('public')->delete($societe->logo);
        }

        $societe->delete();

        return redirect()->route('societes.index')
            ->with('success', 'Société supprimée avec succès.');
    }

    /**
     * Récupérer les gares d'une société
     */
    public function getGares(Societe $societe)
    {
        $gares = $societe->gares;
        return response()->json($gares);
    }

    /**
     * Afficher toutes les gares
     */
    public function garesAll()
    {
        $gares = Gare::with('societe')->orderBy('nom_gare')->get();
        return view('gares.index', compact('gares'));
    }
}