<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DestinationNational;
use App\Models\DestinationSousRegion;
use App\Models\Societe;
use App\Models\Gare;
use App\Models\Lieu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DestinationController extends Controller
{
    /**
     * Display a listing of national destinations.
     *
     * @return \Illuminate\Http\Response
     */
    public function nationalDestinations()
    {
        $destinations = DestinationNational::with(['societe', 'gareDepart', 'lieuDepart', 'lieuArrive'])
            ->where('est_actif', true)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $destinations,
        ]);
    }

    /**
     * Display a listing of regional destinations.
     *
     * @return \Illuminate\Http\Response
     */
    public function regionalDestinations()
    {
        $destinations = DestinationSousRegion::with(['societe', 'gareDepart'])
            ->where('est_actif', true)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $destinations,
        ]);
    }

    /**
     * Display a listing of transport companies.
     *
     * @return \Illuminate\Http\Response
     */
    public function companies()
    {
        $companies = Societe::all();

        return response()->json([
            'status' => 'success',
            'data' => $companies,
        ]);
    }

    /**
     * Display a company's details with its stations.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function companyDetails($id)
    {
        $company = Societe::with('gares')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $company,
        ]);
    }

    /**
     * Display a listing of locations (departure/arrival).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function locations(Request $request)
    {
        $query = Lieu::query();
        
        if ($request->has('type') && in_array($request->type, ['depart', 'arrive', 'les_deux'])) {
            if ($request->type === 'depart') {
                $query->depart();
            } elseif ($request->type === 'arrive') {
                $query->arrive();
            } elseif ($request->type === 'les_deux') {
                $query->where('type', 'les_deux');
            }
        }
        
        $locations = $query->where('est_actif', true)->get();

        return response()->json([
            'status' => 'success',
            'data' => $locations,
        ]);
    }

    /**
     * Search for destinations based on parameters
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:national,sousregion',
            'depart' => 'nullable|string',
            'arrive' => 'nullable|string',
            'societe_id' => 'nullable|integer',
            'date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->type === 'national') {
            $query = DestinationNational::query()->with(['societe', 'gareDepart', 'lieuDepart', 'lieuArrive']);
            
            if ($request->has('depart')) {
                $query->whereHas('lieuDepart', function($q) use ($request) {
                    $q->where('ville', 'like', '%' . $request->depart . '%')
                      ->orWhere('commune', 'like', '%' . $request->depart . '%');
                });
            }
            
            if ($request->has('arrive')) {
                $query->whereHas('lieuArrive', function($q) use ($request) {
                    $q->where('ville', 'like', '%' . $request->arrive . '%')
                      ->orWhere('commune', 'like', '%' . $request->arrive . '%');
                });
            }
        } else {
            $query = DestinationSousRegion::query()->with(['societe', 'gareDepart']);
            
            if ($request->has('arrive')) {
                $query->where(function($q) use ($request) {
                    $q->where('pays_destination', 'like', '%' . $request->arrive . '%')
                      ->orWhere('ville_destination', 'like', '%' . $request->arrive . '%');
                });
            }
        }
        
        if ($request->has('societe_id')) {
            $query->where('societe_id', $request->societe_id);
        }
        
        $destinations = $query->where('est_actif', true)->get();

        return response()->json([
            'status' => 'success',
            'data' => $destinations,
        ]);
    }
}