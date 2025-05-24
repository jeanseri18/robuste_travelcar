<?php

namespace App\Http\Controllers;

use App\Models\DestinationSousRegion;
use App\Models\Societe;
use App\Models\Gare;
use Illuminate\Http\Request;

class DestinationSousRegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinations = DestinationSousRegion::with(['societe', 'gareDepart'])
                                            ->orderBy('created_at', 'desc')
                                            ->get();
        return view('destinations_sousregion.index', compact('destinations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $societes = Societe::orderBy('nom_commercial')->get();
        $pays = $this->getPaysSousRegion();
        return view('destinations_sousregion.create', compact('societes', 'pays'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'societe_id' => 'required|exists:societes,id',
            'gare_depart' => 'required|exists:gares,id',
            'pays_destination' => 'required|string|max:255',
            'ville_destination' => 'required|string|max:255',
            'adresse_destination' => 'nullable|string|max:255',
            'tarif_unitaire' => 'required|numeric|min:0',
            'premier_depart' => 'required',
            'dernier_depart' => 'required',
            'capacite_bus' => 'nullable|integer|min:1',
            'duree_trajet' => 'nullable|integer|min:1',
        ]);

        DestinationSousRegion::create($request->all());

        return redirect()->route('destinations_sousregion.index')
            ->with('success', 'Destination sous-régionale créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DestinationSousRegion $destinationsSousregion)
    {
        return view('destinations_sousregion.show', ['destination' => $destinationsSousregion]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DestinationSousRegion $destinationsSousregion)
    {
        $societes = Societe::orderBy('nom_commercial')->get();
        $gares = Gare::where('societe_id', $destinationsSousregion->societe_id)->get();
        $pays = $this->getPaysSousRegion();
        
        return view('destinations_sousregion.edit', [
            'destination' => $destinationsSousregion,
            'societes' => $societes,
            'gares' => $gares,
            'pays' => $pays
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DestinationSousRegion $destinationsSousregion)
    {
        $request->validate([
            'societe_id' => 'required|exists:societes,id',
            'gare_depart' => 'required|exists:gares,id',
            'pays_destination' => 'required|string|max:255',
            'ville_destination' => 'required|string|max:255',
            'adresse_destination' => 'nullable|string|max:255',
            'tarif_unitaire' => 'required|numeric|min:0',
            'premier_depart' => 'required',
            'dernier_depart' => 'required',
            'capacite_bus' => 'nullable|integer|min:1',
            'duree_trajet' => 'nullable|integer|min:1',
        ]);

        $destinationsSousregion->update($request->all());

        return redirect()->route('destinations_sousregion.index')
            ->with('success', 'Destination sous-régionale mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestinationSousRegion $destinationsSousregion)
    {
        $destinationsSousregion->delete();

        return redirect()->route('destinations_sousregion.index')
            ->with('success', 'Destination sous-régionale supprimée avec succès.');
    }

    /**
     * Liste des pays de la sous-région
     */
    private function getPaysSousRegion()
    {
        return [
            'Bénin',
            'Burkina Faso',
            'Cap-Vert',
            'Gambie',
            'Ghana',
            'Guinée',
            'Guinée-Bissau',
            'Libéria',
            'Mali',
            'Niger',
            'Nigéria',
            'Sénégal',
            'Sierra Leone',
            'Togo'
        ];
    }
}