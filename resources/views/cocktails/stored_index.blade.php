@extends('layouts.app')

@section('content')
    <h3 class="mb-4">Cócteles Guardados</h3>

    <table id="tableCocktails" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Tipo</th>
                <th>Vaso</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($cocktails as $c)
                <tr>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->category }}</td>
                    <td>{{ $c->alcoholic }}</td>
                    <td>{{ $c->glass }}</td>
                    <td>
                        <a href="{{ route('cocktails.edit', $c) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <button onclick="deleteCocktail('{{ route('cocktails.destroy', $c) }}')" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#tableCocktails').DataTable();
        });

        function deleteCocktail(url) {
            Swal.fire({
                title: "¿Eliminar?",
                text: "No podrás revertir esto",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
            }).then((res) => {
                if (res.isConfirmed) {
                    $.ajax({
                        url,
                        type: "DELETE",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr("content")
                        },
                        success: () => location.reload()
                    });
                }
            });
        }
    </script>
@endpush
