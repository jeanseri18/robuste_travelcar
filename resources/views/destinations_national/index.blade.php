@extends('layouts.app')

@section('title', 'Destinations Nationales | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Destinations Nationales</h1>
        <a href="{{ route('destinations_national.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Ajouter une Destination
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Destinations Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Destinations Nationales</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="Table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Société</th>
                            <th>Gare de Départ</th>
                            <th>Itinéraire</th>
                            <th>Tarif</th>
                            <th>Horaires</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($destinations as $destination)
                            <tr>
                                <td>{{ $destination->id }}</td>
                                <td>{{ $destination->societe->nom_commercial ?? 'Non spécifié' }}</td>
                                <td>{{ $destination->gareDepart->nom_gare ?? 'Non spécifié' }}</td>
                                <td>
                                    @if($destination->lieuDepart && $destination->lieuArrive)
                                        {{ $destination->lieuDepart->ville }} → {{ $destination->lieuArrive->ville }}
                                    @else
                                        Itinéraire incomplet
                                    @endif
                                </td>
                                <td>{{ number_format($destination->tarif_unitaire, 0, ',', ' ') }} CFA</td>
                                <td>{{ substr($destination->premier_depart, 0, 5) }} - {{ substr($destination->dernier_depart, 0, 5) }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('destinations_national.show', $destination->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('destinations_national.edit', $destination->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" 
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $destination->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $destination->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $destination->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $destination->id }}">Confirmation de suppression</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer la destination 
                                                    <strong>
                                                        @if($destination->lieuDepart && $destination->lieuArrive)
                                                            {{ $destination->lieuDepart->ville }} → {{ $destination->lieuArrive->ville }}
                                                        @else
                                                            #{{ $destination->id }}
                                                        @endif
                                                    </strong> ?
                                                    <br>
                                                    Cette action est irréversible.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('destinations_national.destroy', $destination->id) }}" method="POST" class="d-inline">
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