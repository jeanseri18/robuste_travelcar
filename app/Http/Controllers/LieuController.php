<?php

namespace App\Http\Controllers;

use App\Models\Lieu;
use Illuminate\Http\Request;

class LieuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lieux = Lieu::orderBy('ville')->get();
        return view('lieux.index', compact('lieux'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lieux.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ville' => 'required|string|max:255',
            'commune' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'departement' => 'nullable|string|max:255',
            'sous_prefecture' => 'nullable|string|max:255',
            'type' => 'required|in:depart,arrive,les_deux',
        ]);

        Lieu::create($request->all());

        return redirect()->route('lieux.index')
            ->with('success', 'Lieu créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lieu $lieu)
    {
        return view('lieux.show', compact('lieu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lieu $lieu)
    {
        return view('lieux.edit', compact('lieu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lieu $lieu)
    {
        $request->validate([
            'ville' => 'required|string|max:255',
            'commune' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'departement' => 'nullable|string|max:255',
            'sous_prefecture' => 'nullable|string|max:255',
            'type' => 'required|in:depart,arrive,les_deux',
        ]);

        $lieu->update($request->all());

        return redirect()->route('lieux.index')
            ->with('success', 'Lieu mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lieu $lieu)
    {
        $lieu->delete();

        return redirect()->route('lieux.index')
            ->with('success', 'Lieu supprimé avec succès.');
    }

    /**
     * Obtenir les lieux de départ et d'arrivée pour les formulaires de destination.
     */
    public function getLieux()
    {
        $depart = Lieu::where('type', 'depart')->orWhere('type', 'les_deux')->get();
        $arrive = Lieu::where('type', 'arrive')->orWhere('type', 'les_deux')->get();

        return response()->json([
            'depart' => $depart,
            'arrive' => $arrive
        ]);
    }
}