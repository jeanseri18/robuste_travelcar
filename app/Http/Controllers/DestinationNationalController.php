<?php

namespace App\Http\Controllers;

use App\Models\DestinationNational;
use App\Models\Societe;
use App\Models\Gare;
use App\Models\Lieu;
use Illuminate\Http\Request;

class DestinationNationalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinations = DestinationNational::with(['societe', 'gareDepart', 'lieuDepart', 'lieuArrive'])
                                          ->orderBy('created_at', 'desc')
                                          ->get();
        return view('destinations_national.index', compact('destinations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $societes = Societe::orderBy('nom_commercial')->get();
        $lieux_depart = Lieu::where('typedestination', 'national')
                           ->where(function($query) {
                               $query->where('type', 'depart')
                                     ->orWhere('type', 'les_deux');
                           })
                           ->where('est_actif', true)
                           ->orderBy('ville')
                           ->get();
        $lieux_arrive = Lieu::where('typedestination', 'national')
                           ->where(function($query) {
                               $query->where('type', 'arrive')
                                     ->orWhere('type', 'les_deux');
                           })
                           ->where('est_actif', true)
                           ->orderBy('ville')
                           ->get();
        
        return view('destinations_national.create', compact('societes', 'lieux_depart', 'lieux_arrive'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'societe_id' => 'required|exists:societes,id',
            'gare_depart' => 'required|exists:gares,id',
            'depart' => 'required|exists:lieux,id',
            'arrive' => 'required|exists:lieux,id|different:depart',
            'tarif_unitaire' => 'required|numeric|min:0',
            'premier_depart' => 'required',
            'dernier_depart' => 'required',
            'capacite_bus' => 'nullable|integer|min:1',
            'frequence_departs' => 'nullable|integer|min:1',
        ]);

        DestinationNational::create($request->all());

        return redirect()->route('destinations_national.index')
            ->with('success', 'Destination nationale créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DestinationNational $destinationsNational)
    {
        return view('destinations_national.show', ['destination' => $destinationsNational]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DestinationNational $destinationsNational)
    {
        $societes = Societe::orderBy('nom_commercial')->get();
        $gares = Gare::where('societe_id', $destinationsNational->societe_id)->get();
        $lieux_depart = Lieu::where('typedestination', 'national')
                           ->where(function($query) {
                               $query->where('type', 'depart')
                                     ->orWhere('type', 'les_deux');
                           })
                           ->where('est_actif', true)
                           ->orderBy('ville')
                           ->get();
        $lieux_arrive = Lieu::where('typedestination', 'national')
                           ->where(function($query) {
                               $query->where('type', 'arrive')
                                     ->orWhere('type', 'les_deux');
                           })
                           ->where('est_actif', true)
                           ->orderBy('ville')
                           ->get();
        
        return view('destinations_national.edit', [
            'destination' => $destinationsNational,
            'societes' => $societes,
            'gares' => $gares,
            'lieux_depart' => $lieux_depart,
            'lieux_arrive' => $lieux_arrive
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DestinationNational $destinationsNational)
    {
        $request->validate([
            'societe_id' => 'required|exists:societes,id',
            'gare_depart' => 'required|exists:gares,id',
            'depart' => 'required|exists:lieux,id',
            'arrive' => 'required|exists:lieux,id|different:depart',
            'tarif_unitaire' => 'required|numeric|min:0',
            'premier_depart' => 'required',
            'dernier_depart' => 'required',
            'capacite_bus' => 'nullable|integer|min:1',
            'frequence_departs' => 'nullable|integer|min:1',
        ]);

        $destinationsNational->update($request->all());

        return redirect()->route('destinations_national.index')
            ->with('success', 'Destination nationale mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestinationNational $destinationsNational)
    {
        $destinationsNational->delete();

        return redirect()->route('destinations_national.index')
            ->with('success', 'Destination nationale supprimée avec succès.');
    }
}