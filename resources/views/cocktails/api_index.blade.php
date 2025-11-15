@extends('layouts.app')

@section('content')
    <h3 class="mb-4">Cócteles desde la API</h3>

    <div class="row">
        @foreach ($drinks as $drink)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card shadow-sm">
                    <img src="{{ $drink['strDrinkThumb'] }}" class="card-img-top" alt="cocktail">

                    <div class="card-body">
                        <h5 class="card-title">{{ $drink['strDrink'] }}</h5>
                        <p class="text-muted mb-1">Categoría: {{ $drink['strCategory'] }}</p>
                        <p class="text-muted">Tipo: {{ $drink['strAlcoholic'] }}</p>

                        <button class="btn btn-primary w-100 btn-save-cocktail" data-id="{{ $drink['idDrink'] }}"
                            data-name="{{ $drink['strDrink'] }}" data-category="{{ $drink['strCategory'] }}"
                            data-alcoholic="{{ $drink['strAlcoholic'] }}" data-glass="{{ $drink['strGlass'] }}"
                            data-instructions="{{ $drink['strInstructions'] }}" data-thumb="{{ $drink['strDrinkThumb'] }}">
                            <i class="bi bi-cloud-plus"></i> Guardar
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {

            $(".btn-save-cocktail").click(function() {
                const btn = $(this);

                $.ajax({
                    url: "{{ route('cocktails.store') }}",
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                        cocktail_id: btn.data("id"),
                        name: btn.data("name"),
                        category: btn.data("category"),
                        alcoholic: btn.data("alcoholic"),
                        glass: btn.data("glass"),
                        instructions: btn.data("instructions"),
                        thumbnail: btn.data("thumb"),
                    },
                    success: function() {
                        Swal.fire("Guardado", "El cóctel fue registrado", "success");
                    },
                    error: function() {
                        Swal.fire("Error", "No se pudo guardar", "error");
                    }
                });
            });

        });
    </script>
@endpush
