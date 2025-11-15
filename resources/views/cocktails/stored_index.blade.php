@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h3 class="mb-0">Cócteles Guardados</h3>
            <small class="text-muted">Administra, edita o elimina los cócteles que guardaste.</small>
        </div>

        <div>
            <a href="{{ route('cocktails.api') }}" class="btn btn-outline-secondary global-nav">
                <i class="bi bi-list-stars"></i> Ver API
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table id="tableCocktails" class="table table-striped table-dark table-hover">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Tipo</th>
                <th>Vaso</th>
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cocktails as $c)
                <tr data-id="{{ $c->id }}">
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->category }}</td>
                    <td>{{ $c->alcoholic }}</td>
                    <td>{{ $c->glass }}</td>
                    <td class="text-end">
                        <a href="{{ route('cocktails.edit', $c) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <button class="btn btn-sm btn-danger btn-delete" data-url="{{ route('cocktails.destroy', $c) }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div id="globalLoader" class="global-loader" style="display:none;">
        <div class="loader-inner">
            <div class="shaker">
                <div class="shaker-body"></div>
                <div class="spark"></div>
            </div>
            <div class="loader-text">Cargando...</div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .table-dark thead th {
            background: rgba(0, 0, 0, 0.45);
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        }

        .global-loader {
            position: fixed;
            inset: 0;
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.6));
            color: #fff;
        }

        .btn-sm {
            padding: .35rem .5rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(function() {
            const table = $('#tableCocktails').DataTable({
                paging: true,
                ordering: true,
                info: true,
                responsive: true,
                pageLength: 10,
                language: {
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_"
                }
            });

            function showGlobalLoader(show = true, text = 'Cargando...') {
                const $loader = $('#globalLoader');
                if (show) {
                    $loader.find('.loader-text').text(text);
                    $loader.stop(true).fadeIn(120);
                } else {
                    $loader.stop(true).fadeOut(120);
                }
            }

            $(document).on('click', '.btn-delete', function() {
                const btn = $(this);
                const url = btn.data('url');

                Swal.fire({
                    title: '¿Eliminar?',
                    text: 'Esta acción no se puede revertir.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((res) => {
                    if (!res.isConfirmed) return;
                    showGlobalLoader(true, 'Eliminando...');
                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function() {
                            const row = btn.closest('tr');
                            table.row(row).remove().draw(false);
                            Swal.fire({
                                icon: 'success',
                                title: 'Eliminado',
                                timer: 900,
                                showConfirmButton: false
                            });
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudo eliminar'
                            });
                        },
                        complete: function() {
                            showGlobalLoader(false);
                        }
                    });
                });
            });

            $(document).on('click', '.global-nav', function() {
                showGlobalLoader(true, 'Redirigiendo...');
            });
        });
    </script>
@endpush
