@extends('layouts.app')

@section('title', 'Gestion des Réservations | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Réservations</h1>
        <a href="{{ route('reservations.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Créer une Réservation
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filtres -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtres</h6>
        </div>
        <div class="card-body">
            <form id="filterForm" method="GET" action="{{ route('reservations.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="statut" class="form-label">Statut</label>
                        <select class="form-select" id="statut" name="statut">
                            <option value="">Tous les statuts</option>
                            <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="confirmee" {{ request('statut') == 'confirmee' ? 'selected' : '' }}>Confirmée</option>
                            <option value="annulee" {{ request('statut') == 'annulee' ? 'selected' : '' }}>Annulée</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="date_debut" class="form-label">Date de début</label>
                        <input type="date" class="form-control" id="date_debut" name="date_debut" value="{{ request('date_debut') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="date_fin" class="form-label">Date de fin</label>
                        <input type="date" class="form-control" id="date_fin" name="date_fin" value="{{ request('date_fin') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="societe_id" class="form-label">Société</label>
                        <select class="form-select" id="societe_id" name="societe_id">
                            <option value="">Toutes les sociétés</option>
                            @foreach($societes ?? [] as $societe)
                                <option value="{{ $societe->id }}" {{ request('societe_id') == $societe->id ? 'selected' : '' }}>
                                    {{ $societe->nom_commercial }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-filter"></i> Filtrer
                    </button>
                    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Réservations Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Réservations</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="Table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Client</th>
                            <th>Destination</th>
                            <th>Date</th>
                            <th>Tickets</th>
                            <th>Total</th>
                            <th>Statut</th>
                            <th>Paiement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->code_reservation }}</td>
                                <td>
                                    <a href="{{ route('users.show', $reservation->user->id) }}">
                                        {{ $reservation->user->nom }} {{ $reservation->user->prenom }}
                                    </a>
                                </td>
                                <td>
                                    @if($reservation->type_destination === 'national')
                                        @php
                                            $dest = App\Models\DestinationNational::with(['lieuDepart', 'lieuArrive'])->find($reservation->destination_id);
                                        @endphp
                                        @if($dest && $dest->lieuDepart && $dest->lieuArrive)
                                            {{ $dest->lieuDepart->ville }} → {{ $dest->lieuArrive->ville }}
                                        @else
                                            Destination nationale
                                        @endif
                                    @else
                                        @php
                                            $dest = App\Models\DestinationSousRegion::find($reservation->destination_id);
                                        @endphp
                                        @if($dest)
                                            CDI → {{ $dest->pays_destination }}
                                        @else
                                            Destination sous-régionale
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $reservation->date_depart->format('d/m/Y') }}</td>
                                <td>{{ $reservation->nombre_tickets }}</td>
                                <td>{{ number_format($reservation->total, 0, ',', ' ') }} CFA</td>
                                <td>
                                    @switch($reservation->statut)
                                        @case('en_attente')
                                            <span class="badge bg-warning">En attente</span>
                                            @break
                                        @case('confirmee')
                                            <span class="badge bg-success">Confirmée</span>
                                            @break
                                        @case('annulee')
                                            <span class="badge bg-danger">Annulée</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $reservation->statut }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    @if($reservation->paiement)
                                        @switch($reservation->paiement->statut)
                                            @case('en_attente')
                                                <span class="badge bg-warning">En attente</span>
                                                @break
                                            @case('complete')
                                                <span class="badge bg-success">Complété</span>
                                                @break
                                            @case('echoue')
                                                <span class="badge bg-danger">Échoué</span>
                                                @break
                                            @case('remboursement')
                                                <span class="badge bg-info">Remboursé</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ $reservation->paiement->statut }}</span>
                                        @endswitch
                                    @else
                                        <span class="badge bg-secondary">Non payé</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" 
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $reservation->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $reservation->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $reservation->id }}">Confirmation de suppression</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer la réservation <strong>{{ $reservation->code_reservation }}</strong> ?
                                                    <br>
                                                    Cette action est irréversible.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('styles')
<link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/r-3.0.3/datatables.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/r-3.0.3/datatables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#Table').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print', 'colvis'
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"

            }
        });
    });
</script>
@endpush