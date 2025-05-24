<?php

namespace App\Http\Controllers;

use App\Models\Gare;
use App\Models\Societe;
use Illuminate\Http\Request;

class GareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gares = Gare::with('societe')->orderBy('nom_gare')->get();
        return view('gares.index', compact('gares'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $societes = Societe::orderBy('nom_commercial')->get();
        return view('gares.create', compact('societes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'societe_id' => 'required|exists:societes,id',
            'nom_gare' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'required|string|max:255',
            'commune' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'responsable' => 'nullable|string|max:255',
        ]);

        Gare::create($request->all());

        return redirect()->route('gares.index')
            ->with('success', 'Gare créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gare $gare)
    {
        return view('gares.show', compact('gare'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gare $gare)
    {
        $societes = Societe::orderBy('nom_commercial')->get();
        return view('gares.edit', compact('gare', 'societes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gare $gare)
    {
        $request->validate([
            'societe_id' => 'required|exists:societes,id',
            'nom_gare' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'required|string|max:255',
            'commune' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'responsable' => 'nullable|string|max:255',
        ]);

        $gare->update($request->all());

        return redirect()->route('gares.index')
            ->with('success', 'Gare mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gare $gare)
    {
        $gare->delete();

        return redirect()->route('gares.index')
            ->with('success', 'Gare supprimée avec succès.');
    }
}