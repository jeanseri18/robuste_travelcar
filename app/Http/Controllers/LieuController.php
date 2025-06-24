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

    /**
     * Obtenir les lieux de départ pour les destinations nationales.
     */
    public function getLieuxDepartNational()
    {
        $lieux = Lieu::where('typedestination', 'national')
                    ->where(function($query) {
                        $query->where('type', 'depart')
                              ->orWhere('type', 'les_deux');
                    })
                    ->where('est_actif', true)
                    ->orderBy('ville')
                    ->get();

        return response()->json($lieux);
    }

    /**
     * Obtenir les lieux d'arrivée pour les destinations nationales.
     */
    public function getLieuxArriveNational()
    {
        $lieux = Lieu::where('typedestination', 'national')
                    ->where(function($query) {
                        $query->where('type', 'arrive')
                              ->orWhere('type', 'les_deux');
                    })
                    ->where('est_actif', true)
                    ->orderBy('ville')
                    ->get();

        return response()->json($lieux);
    }

    /**
     * Obtenir les lieux de départ pour les destinations sous-régionales.
     */
    public function getLieuxDepartSousRegion()
    {
        $lieux = Lieu::where('typedestination', 'sousregion')
                    ->where(function($query) {
                        $query->where('type', 'depart')
                        ;
                    })
                    ->where('est_actif', true)
                    ->orderBy('ville')
                    ->get();

        return response()->json($lieux);
    }

    /**
     * Obtenir les lieux d'arrivée pour les destinations sous-régionales.
     */
    public function getLieuxArriveSousRegion()
    {
        $lieux = Lieu::where('typedestination', 'sousregion')
                    ->where(function($query) {
                        $query->where('type', 'arrive')
                    ;
                    })
                    ->where('est_actif', true)
                    ->orderBy('ville')
                    ->get();

        return response()->json($lieux);
    }

    /**
     * Obtenir les lieux de départ et d'arrivée filtrés par type de destination.
     */
    public function getLieuxByTypeDestination($typeDestination)
    {
        if (!in_array($typeDestination, ['national', 'sousregion'])) {
            return response()->json(['error' => 'Type de destination invalide'], 400);
        }

        $depart = Lieu::where('typedestination', $typeDestination)
                     ->where(function($query) {
                         $query->where('type', 'depart')
                              ;
                     })
                     ->where('est_actif', true)
                     ->orderBy('ville')
                     ->get();

        $arrive = Lieu::where('typedestination', $typeDestination)
                     ->where(function($query) {
                         $query->where('type', 'arrive')
                          ;
                     })
                     ->where('est_actif', true)
                     ->orderBy('ville')
                     ->get();

        return response()->json([
            'depart' => $depart,
            'arrive' => $arrive
        ]);
    }

    /**
     * Obtenir les villes par pays pour les destinations sous-régionales.
     */
    public function getVillesParPays($pays, Request $request)
    {
        // Décoder l'URL pour gérer les caractères spéciaux comme les accents
        $pays = urldecode($pays);
        $type = $request->query('type'); // Récupérer le paramètre type (depart/arrive)
        
        // Construire la requête de base
        $query = Lieu::where('pays', $pays)
                    ->where('typedestination', 'sousregion')
                    ->where('est_actif', true);
        
        // Ajouter le filtre par type si spécifié
        if ($type && in_array($type, ['depart', 'arrive'])) {
            $query->where('type', $type);
        }
        
        // Vérifier si le pays existe dans la base de données
        $paysExiste = $query->exists();

        if (!$paysExiste) {
            return response()->json([
                'error' => 'Pays non trouvé dans la base de données' . ($type ? " pour le type {$type}" : ''),
                'pays' => $pays,
                'type' => $type,
                'villes' => []
            ], 404);
        }

        $villes = $query->distinct()
                       ->pluck('ville')
                       ->sort()
                       ->values();

        return response()->json([
            'pays' => $pays,
            'type' => $type,
            'villes' => $villes
        ]);
    }

    /**
     * Obtenir les détails d'un lieu spécifique.
     */
    public function getLieuDetails(Request $request)
    {
        $pays = $request->query('pays');
        $ville = $request->query('ville');

        if (!$pays || !$ville) {
            return response()->json(['error' => 'Pays et ville requis'], 400);
        }
        
        // Décoder les paramètres URL pour gérer les caractères spéciaux
        $pays = urldecode($pays);
        $ville = urldecode($ville);

        $lieu = Lieu::where('pays', $pays)
                   ->where('ville', $ville)
                   ->where('typedestination', 'sousregion')
                   ->where('est_actif', true)
                   ->first();

        if (!$lieu) {
            return response()->json(['error' => 'Lieu non trouvé'], 404);
        }

        return response()->json($lieu);
    }
}