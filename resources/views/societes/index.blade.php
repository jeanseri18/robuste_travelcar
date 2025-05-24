@extends('layouts.app')

@section('title', 'Gestion des Sociétés | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Sociétés de Transport</h1>
        <a href="{{ route('societes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Ajouter une Société
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Sociétés Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Sociétés</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="Table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Logo</th>
                            <th>Nom Commercial</th>
                            <th>Forme Juridique</th>
                            <th>Contact</th>
                            <th>Gares</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($societes as $societe)
                            <tr>
                                <td>{{ $societe->id }}</td>
                                <td class="text-center">
                                    @if($societe->logo)
                                        <img src="{{ asset('storage/' . $societe->logo) }}" alt="{{ $societe->nom_commercial }}" width="50">
                                    @else
                                        <i class="bi bi-building" style="font-size: 2rem;"></i>
                                    @endif
                                </td>
                                <td>{{ $societe->nom_commercial }}</td>
                                <td>{{ $societe->forme_juridique ?? 'Non spécifié' }}</td>
                                <td>
                                    @if($societe->telephone)
                                        <a href="tel:{{ $societe->telephone }}">{{ $societe->telephone }}</a>
                                    @else
                                        Non spécifié
                                    @endif
                                </td>
                                <td>{{ $societe->gares->count() }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('societes.show', $societe->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('societes.edit', $societe->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" 
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $societe->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $societe->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $societe->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $societe->id }}">Confirmation de suppression</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
<div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer la société <strong>{{ $societe->nom_commercial }}</strong> ?
                                                    <br>
                                                    Cette action est irréversible et supprimera également toutes les gares, destinations et réservations associées.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('societes.destroy', $societe->id) }}" method="POST" class="d-inline">
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