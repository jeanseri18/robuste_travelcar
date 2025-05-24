@extends('layouts.app')

@section('title', 'Gestion des Paiements | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Paiements</h1>
        <a href="{{ route('paiements.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Enregistrer un Paiement
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
            <form id="filterForm" method="GET" action="{{ route('paiements.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="statut" class="form-label">Statut</label>
                        <select class="form-select" id="statut" name="statut">
                            <option value="">Tous les statuts</option>
                            <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="complete" {{ request('statut') == 'complete' ? 'selected' : '' }}>Complété</option>
                            <option value="echoue" {{ request('statut') == 'echoue' ? 'selected' : '' }}>Échoué</option>
                            <option value="remboursement" {{ request('statut') == 'remboursement' ? 'selected' : '' }}>Remboursement</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="methode" class="form-label">Méthode</label>
                        <select class="form-select" id="methode" name="methode">
                            <option value="">Toutes les méthodes</option>
                            <option value="orange_money" {{ request('methode') == 'orange_money' ? 'selected' : '' }}>Orange Money</option>
                            <option value="mtn_money" {{ request('methode') == 'mtn_money' ? 'selected' : '' }}>MTN Money</option>
                            <option value="moov_money" {{ request('methode') == 'moov_money' ? 'selected' : '' }}>Moov Money</option>
                            <option value="wave" {{ request('methode') == 'wave' ? 'selected' : '' }}>Wave</option>
                            <option value="cheque" {{ request('methode') == 'cheque' ? 'selected' : '' }}>Chèque</option>
                            <option value="virement" {{ request('methode') == 'virement' ? 'selected' : '' }}>Virement</option>
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
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-filter"></i> Filtrer
                    </button>
                    <a href="{{ route('paiements.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <!-- Total des paiements -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total des paiements</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalPaiements ?? 0, 0, ',', ' ') }} CFA
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-wallet2 fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paiements complétés -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Paiements complétés</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalCompletes ?? 0, 0, ',', ' ') }} CFA
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paiements en attente -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Paiements en attente</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalEnAttente ?? 0, 0, ',', ' ') }} CFA
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-hourglass-split fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paiements échoués -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Paiements échoués</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalEchoues ?? 0, 0, ',', ' ') }} CFA
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-x-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Paiements Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Paiements</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="Table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Réservation</th>
                            <th>Client</th>
                            <th>Montant</th>
                            <th>Méthode</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paiements as $paiement)
                            <tr>
                                <td>{{ $paiement->id }}</td>
                                <td>
                                    <a href="{{ route('reservations.show', $paiement->reservation->id) }}">
                                        {{ $paiement->reservation->code_reservation }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('users.show', $paiement->user->id) }}">
                                        {{ $paiement->user->nom }} {{ $paiement->user->prenom }}
                                    </a>
                                </td>
                                <td>{{ number_format($paiement->montant, 0, ',', ' ') }} CFA</td>
                                <td>
                                    @switch($paiement->methode)
                                        @case('orange_money')
                                            Orange Money
                                            @break
                                        @case('mtn_money')
                                            MTN Money
                                            @break
                                        @case('moov_money')
                                            Moov Money
                                            @break
                                        @case('wave')
                                            Wave
                                            @break
                                        @case('cheque')
                                            Chèque
                                            @break
                                        @case('virement')
                                            Virement
                                            @break
                                        @default
                                            {{ $paiement->methode }}
                                    @endswitch
                                </td>
                                <td>{{ $paiement->date_paiement ? $paiement->date_paiement->format('d/m/Y H:i') : $paiement->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @switch($paiement->statut)
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
                                            <span class="badge bg-info">Remboursement</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $paiement->statut }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('paiements.show', $paiement->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('paiements.edit', $paiement->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" 
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $paiement->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $paiement->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $paiement->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $paiement->id }}">Confirmation de suppression</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer ce paiement de <strong>{{ number_format($paiement->montant, 0, ',', ' ') }} CFA</strong> ?
                                                    <br>
                                                    Cette action est irréversible et pourrait affecter le statut de la réservation associée.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('paiements.destroy', $paiement->id) }}" method="POST" class="d-inline">
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