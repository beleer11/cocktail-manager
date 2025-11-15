@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h3 class="mb-0 text-white">Cócteles Guardados</h3>
            <small class="text-muted">Tus cócteles almacenados localmente.</small>
        </div>

        <div>
            <a href="{{ route('cocktails.api') }}" class="btn btn-outline-light global-nav">
                <i class="bi bi-list-stars"></i> Buscar más cócteles
            </a>
        </div>
    </div>

    @if ($cocktails->count() > 0)
        <div id="cardsGrid" class="row g-3">
            @foreach ($cocktails as $drink)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card cocktail-card h-100 shadow-lg text-light">
                        <div class="media-wrap">
                            <img src="{{ $drink->thumbnail }}" alt="{{ $drink->name }}" class="media-img"
                                onerror="this.src='https://via.placeholder.com/300x300/1a1a2e/00eaff?text=Imagen+no+disponible'">
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-1">{{ $drink->name }}</h5>

                            <div class="text-muted small mb-2 d-flex align-items-center gap-2">
                                <span class="badge neon">{{ $drink->category ?? 'Sin categoría' }}</span>
                                <span class="badge bg-secondary">{{ $drink->alcoholic ?? 'N/A' }}</span>
                            </div>

                            <p class="card-text text-truncate" title="{{ $drink->instructions }}">
                                {{ Str::limit($drink->instructions, 80) }}
                            </p>

                            <div class="mt-auto d-flex gap-2">
                                <button class="btn btn-outline-info preview-btn w-100"
                                    data-drink='@json($drink)'>
                                    <i class="bi bi-eye"></i> Ver
                                </button>

                                <a href="{{ route('cocktails.edit', $drink) }}" class="btn btn-outline-light w-100">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </a>

                                <button class="btn btn-outline-danger w-100 btn-delete" data-id="{{ $drink->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-cup-straw" style="font-size: 4rem; color: #00eaff;"></i>
                </div>
                <h4 class="text-white mt-4">No tienes cócteles guardados</h4>
                <p class="text-white">Comienza explorando la API y guarda tus cócteles favoritos.</p>
                <a href="{{ route('cocktails.api') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-list-stars me-2"></i>Explorar cócteles
                </a>
            </div>
        </div>
    @endif

    <div class="modal fade" id="drinkModal" tabindex="-1" aria-labelledby="drinkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content modal-glass">
                <div class="modal-header border-bottom-0 pb-0">
                    <h4 class="modal-title text-gradient" id="drinkModalLabel">Detalle del Cóctel</h4>
                </div>
                <div class="modal-body pt-0">
                    <div class="row g-4">
                        <div class="col-md-5 text-center">
                            <div class="modal-image-container">
                                <img id="modalThumb" src="" alt="" class="modal-image">
                                <div class="modal-image-glow"></div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="modal-content-section">
                                <h2 id="modalName" class="modal-drink-name text-white mb-3"></h2>

                                <div class="modal-tags mb-4">
                                    <span id="modalCategory" class="modal-tag modal-tag-primary"></span>
                                    <span id="modalAlcoholic" class="modal-tag modal-tag-secondary"></span>
                                    <span id="modalGlass" class="modal-tag modal-tag-accent"></span>
                                </div>

                                <div class="modal-section">
                                    <h5 class="modal-section-title">
                                        <i class="bi bi-list-ul me-2"></i>Ingredientes
                                    </h5>
                                    <div id="modalIngredients" class="modal-ingredients"></div>
                                </div>

                                <div class="modal-section">
                                    <h5 class="modal-section-title">
                                        <i class="bi bi-chat-square-text me-2"></i>Instrucciones
                                    </h5>
                                    <p id="modalInstructions" class="modal-instructions text-light"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-modal-close" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-2"></i>Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .cocktail-card {
            border-radius: 12px;
            overflow: hidden;
            transition: transform .18s ease, box-shadow .18s ease;
            background: linear-gradient(180deg, rgba(15, 15, 20, 0.9), rgba(10, 10, 18, 0.85));
            border: 1px solid rgba(255, 255, 255, 0.03);
        }

        .cocktail-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 50px rgba(13, 110, 253, .18);
        }

        .media-wrap {
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.01));
        }

        .media-img {
            max-height: 160px;
            width: auto;
            object-fit: contain !important;
            border-radius: 8px;
            transition: transform .25s ease, filter .25s ease;
            filter: brightness(.95) saturate(1.05);
        }

        .cocktail-card:hover .media-img {
            transform: scale(1.03);
            filter: brightness(1.06) saturate(1.12);
        }

        .badge.neon {
            background: linear-gradient(90deg, rgba(255, 0, 120, 0.12), rgba(0, 200, 255, 0.12));
            color: #fff;
            border: 1px solid rgba(0, 150, 255, 0.18);
            box-shadow: 0 4px 18px rgba(0, 150, 255, 0.06);
        }

        .btn-outline-light,
        .btn-outline-danger,
        .btn-outline-info {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-info:hover {
            background: rgba(0, 200, 255, 0.1);
            border-color: rgba(0, 200, 255, 0.3);
            transform: translateY(-1px);
        }

        .modal-glass {
            background: linear-gradient(135deg, rgba(15, 15, 25, 0.95), rgba(10, 10, 20, 0.98));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        }

        .modal-image-container {
            position: relative;
            display: inline-block;
        }

        .modal-image {
            width: 100%;
            max-height: 280px;
            object-fit: contain;
            border-radius: 12px;
            position: relative;
            z-index: 2;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.3));
        }

        .modal-image-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            height: 90%;
            background: radial-gradient(circle, rgba(0, 200, 255, 0.15), transparent 70%);
            border-radius: 12px;
            z-index: 1;
        }

        .text-gradient {
            background: linear-gradient(135deg, #00eaff, #ff0080);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .modal-drink-name {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .modal-tags {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .modal-tag {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }

        .modal-tag-primary {
            background: linear-gradient(135deg, rgba(0, 200, 255, 0.2), rgba(0, 150, 255, 0.1));
            border: 1px solid rgba(0, 200, 255, 0.3);
            color: #00eaff;
        }

        .modal-tag-secondary {
            background: linear-gradient(135deg, rgba(255, 0, 120, 0.2), rgba(200, 0, 100, 0.1));
            border: 1px solid rgba(255, 0, 120, 0.3);
            color: #ff0080;
        }

        .modal-tag-accent {
            background: linear-gradient(135deg, rgba(120, 255, 0, 0.2), rgba(100, 200, 0, 0.1));
            border: 1px solid rgba(120, 255, 0, 0.3);
            color: #78ff00;
        }

        .modal-section {
            margin-bottom: 2rem;
        }

        .modal-section-title {
            color: #00eaff;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .modal-ingredients {
            display: grid;
            gap: 0.5rem;
        }

        .modal-ingredient {
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 8px;
            color: #fff;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .modal-ingredient:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(0, 200, 255, 0.2);
            transform: translateX(5px);
        }

        .modal-instructions {
            line-height: 1.6;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.9);
            background: rgba(255, 255, 255, 0.05);
            padding: 1.5rem;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .btn-modal-close {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-modal-close:hover {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.08));
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).on('click', '.preview-btn', function() {
            const drink = $(this).data('drink');

            $('#modalName').text(drink.name || 'Detalle');
            $('#modalThumb').attr('src', drink.thumbnail || '');
            $('#modalCategory').text(drink.category || '—');
            $('#modalAlcoholic').text(drink.alcoholic || '—');
            $('#modalGlass').text(drink.glass || '—');
            $('#modalInstructions').text(drink.instructions || 'No hay instrucciones disponibles.');

            const ingredientsHtml = renderIngredients(drink.ingredients);
            $('#modalIngredients').html(ingredientsHtml);

            const modal = new bootstrap.Modal(document.getElementById('drinkModal'), {
                keyboard: true
            });
            modal.show();
        });

        function renderIngredients(ingredientsString) {
            if (!ingredientsString || ingredientsString.trim() === '') {
                return '<div class="modal-ingredient">No hay ingredientes registrados.</div>';
            }

            const ingredients = ingredientsString.split('\n').filter(ing => ing.trim() !== '');

            if (ingredients.length === 0) {
                return '<div class="modal-ingredient">No hay ingredientes registrados.</div>';
            }

            return ingredients.map(ingredient => {
                const trimmedIngredient = ingredient.trim();
                if (!trimmedIngredient) return '';

                return `
                    <div class="modal-ingredient">
                        <i class="bi bi-dot me-2"></i>${trimmedIngredient}
                    </div>
                `;
            }).join('');
        }

        $(".btn-delete").click(function() {
            const id = $(this).data("id");

            Swal.fire({
                title: "¿Eliminar cóctel?",
                text: "Esta acción no se puede deshacer.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar",
                background: 'linear-gradient(135deg, rgba(15, 15, 25, 0.95), rgba(10, 10, 20, 0.98))',
                color: '#fff',
                customClass: {
                    popup: 'sweetalert-popup'
                },
                reverseButtons: true
            }).then(result => {
                if (!result.isConfirmed) return;

                $.ajax({
                    url: "/cocktails/" + id,
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function() {
                        Swal.fire({
                            icon: "success",
                            title: "Eliminado",
                            text: "El cóctel ha sido eliminado",
                            timer: 1500,
                            showConfirmButton: false,
                            background: 'linear-gradient(135deg, rgba(15, 15, 25, 0.95), rgba(10, 10, 20, 0.98))',
                            color: '#fff',
                            customClass: {
                                popup: 'sweetalert-popup'
                            }
                        });

                        setTimeout(() => location.reload(), 1200);
                    },
                    error: function() {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "No se pudo eliminar el cóctel",
                            background: 'linear-gradient(135deg, rgba(15, 15, 25, 0.95), rgba(10, 10, 20, 0.98))',
                            color: '#fff',
                            customClass: {
                                popup: 'sweetalert-popup'
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
