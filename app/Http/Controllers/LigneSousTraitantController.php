<?php

namespace App\Http\Controllers;

use App\Models\LigneSousTraitant;
use App\Models\SousTraitant;
use App\Models\Societe;
use App\Models\DestinationNational;
use App\Models\DestinationSousRegion;
use Illuminate\Http\Request;

class LigneSousTraitantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lignes = LigneSousTraitant::with(['sousTraitant.user', 'societe'])
                                  ->orderBy('created_at', 'desc')
                                  ->get();
        return view('lignes_soustraitants.index', compact('lignes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $soustraitants = SousTraitant::with('user')->where('est_actif', true)->get();
        $societes = Societe::orderBy('nom_commercial')->get();
        return view('lignes_soustraitants.create', compact('soustraitants', 'societes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sous_traitant_id' => 'required|exists:sous_traitants,id',
            'type_destination' => 'required|in:national,sousregion',
            'destination_id' => 'required|integer',
            'societe_id' => 'required|exists:societes,id',
            'type_ligne' => 'required|in:aller_simple,retour_simple,aller_retour',
        ]);

        // Vérifier si la destination existe
        if ($request->type_destination === 'national') {
            $destination = DestinationNational::find($request->destination_id);
        } else {
            $destination = DestinationSousRegion::find($request->destination_id);
        }

        if (!$destination || $destination->societe_id != $request->societe_id) {
            return redirect()->back()
                ->withErrors(['destination_id' => 'La destination sélectionnée est invalide.'])
                ->withInput();
        }

        LigneSousTraitant::create($request->all());

        return redirect()->route('lignes_soustraitants.index')
            ->with('success', 'Ligne de sous-traitant créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LigneSousTraitant $lignesSoustraitant)
    {
        $lignesSoustraitant->load(['sousTraitant.user', 'societe']);
        
        // Récupérer la destination
        if ($lignesSoustraitant->type_destination === 'national') {
            $destination = DestinationNational::with(['lieuDepart', 'lieuArrive'])
                                             ->find($lignesSoustraitant->destination_id);
        } else {
            $destination = DestinationSousRegion::find($lignesSoustraitant->destination_id);
        }

        return view('lignes_soustraitants.show', [
            'ligne' => $lignesSoustraitant,
            'destination' => $destination
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LigneSousTraitant $lignesSoustraitant)
    {
        $soustraitants = SousTraitant::with('user')->where('est_actif', true)->get();
        $societes = Societe::orderBy('nom_commercial')->get();
        
        // Récupérer les destinations selon le type
        if ($lignesSoustraitant->type_destination === 'national') {
            $destinations = DestinationNational::where('societe_id', $lignesSoustraitant->societe_id)
                                             ->with(['lieuDepart', 'lieuArrive'])
                                             ->get();
        } else {
            $destinations = DestinationSousRegion::where('societe_id', $lignesSoustraitant->societe_id)
                                               ->get();
        }

        return view('lignes_soustraitants.edit', [
            'ligne' => $lignesSoustraitant,
            'soustraitants' => $soustraitants,
            'societes' => $societes,
            'destinations' => $destinations
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LigneSousTraitant $lignesSoustraitant)
    {
        $request->validate([
            'sous_traitant_id' => 'required|exists:sous_traitants,id',
            'type_destination' => 'required|in:national,sousregion',
            'destination_id' => 'required|integer',
            'societe_id' => 'required|exists:societes,id',
            'type_ligne' => 'required|in:aller_simple,retour_simple,aller_retour',
            'est_actif' => 'boolean',
        ]);

        // Vérifier si la destination existe
        if ($request->type_destination === 'national') {
            $destination = DestinationNational::find($request->destination_id);
        } else {
            $destination = DestinationSousRegion::find($request->destination_id);
        }

        if (!$destination || $destination->societe_id != $request->societe_id) {
            return redirect()->back()
                ->withErrors(['destination_id' => 'La destination sélectionnée est invalide.'])
                ->withInput();
        }

        $lignesSoustraitant->update($request->all());

        return redirect()->route('lignes_soustraitants.index')
            ->with('success', 'Ligne de sous-traitant mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LigneSousTraitant $lignesSoustraitant)
    {
        $lignesSoustraitant->delete();

        return redirect()->route('lignes_soustraitants.index')
            ->with('success', 'Ligne de sous-traitant supprimée avec succès.');
    }

    /**
     * Récupérer les destinations selon la société et le type
     */
    public function getDestinations(Request $request)
    {
        $request->validate([
            'societe_id' => 'required|exists:societes,id',
            'type_destination' => 'required|in:national,sousregion',
        ]);

        if ($request->type_destination === 'national') {
            $destinations = DestinationNational::where('societe_id', $request->societe_id)
                                             ->with(['lieuDepart', 'lieuArrive'])
                                             ->get();
        } else {
            $destinations = DestinationSousRegion::where('societe_id', $request->societe_id)
                                               ->get();
        }

        return response()->json($destinations);
    }
}