@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h3 class="mb-0 text-white">Cócteles desde la API</h3>
            <small class="text-white">Explora, filtra y guarda tus favoritos.</small>
        </div>

        <div>
            <a href="{{ route('cocktails.stored') }}" class="btn btn-outline-light global-nav">
                <i class="bi bi-collection"></i> Guardados
            </a>
        </div>
    </div>

    <div class="card mb-4 shadow-sm bg-dark text-light" style="border: 1px solid rgba(255,255,255,0.03);">
        <div class="card-body">
            <form id="filtersForm" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <input id="q" name="q" type="search" class="form-control form-control-dark"
                        placeholder="Buscar por nombre (ej: margarita)" value="{{ $search_query ?? '' }}">
                </div>

                <div class="col-md-3">
                    <select id="category" name="category" class="form-select form-select-dark">
                        <option value="">Todas las categorías</option>
                        @foreach ($filters['categories'] ?? [] as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="alcoholic" name="alcoholic" class="form-select form-select-dark">
                        <option value="">Cualquiera</option>
                        @foreach ($filters['alcoholic'] ?? [] as $a)
                            <option value="{{ $a }}" {{ request('alcoholic') == $a ? 'selected' : '' }}>
                                {{ $a }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="sort" name="sort" class="form-select form-select-dark">
                        <option value="">Orden</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nombre ↑</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nombre ↓</option>
                    </select>
                </div>

                <div class="col-md-1 text-end">
                    <button id="resetFilters" type="button" class="btn btn-light" title="Limpiar">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="cardsGrid" class="row g-3">
        @foreach ($drinks as $drink)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card cocktail-card h-100 shadow-lg text-light" data-id="{{ $drink['idDrink'] }}">
                    <div class="media-wrap">
                        <img src="{{ $drink['strDrinkThumb'] }}" alt="{{ $drink['strDrink'] }}" class="media-img">
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-1">{{ $drink['strDrink'] }}</h5>
                        <div class="text-muted small mb-2 d-flex align-items-center gap-2">
                            <span class="badge neon">{{ $drink['strCategory'] ?? '—' }}</span>
                            <span class="badge bg-secondary">{{ $drink['strAlcoholic'] ?? '—' }}</span>
                        </div>

                        <p class="card-text text-truncate" title="{{ $drink['strInstructions'] ?? '' }}">
                            {{ \Illuminate\Support\Str::limit($drink['strInstructions'] ?? 'Sin instrucciones', 80) }}
                        </p>

                        <div class="mt-auto d-flex gap-2">
                            <button class="btn btn-ghost-save btn-save-cocktail" data-id="{{ $drink['idDrink'] }}"
                                data-name="{{ $drink['strDrink'] }}" data-category="{{ $drink['strCategory'] }}"
                                data-alcoholic="{{ $drink['strAlcoholic'] }}" data-glass="{{ $drink['strGlass'] }}"
                                data-instructions="{{ $drink['strInstructions'] }}"
                                data-thumb="{{ $drink['strDrinkThumb'] }}">
                                <span class="btn-label"><i class="bi bi-cloud-plus"></i> Guardar</span>
                                <span class="btn-bubbles"></span>
                            </button>

                            <button class="btn btn-outline-light preview-btn" data-drink='@json($drink, JSON_HEX_APOS)'>
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div id="globalLoader" class="global-loader" style="display:none;">
        <div class="loader-inner">
            <div class="shaker">
                <div class="shaker-body"></div>
                <div class="spark"></div>
            </div>
            <div class="loader-text">Cargando...</div>
        </div>
    </div>

    <div id="loader" class="text-center py-4" style="display: none;">
        <div class="spinner-border text-light" role="status"></div>
    </div>

    <div id="endMsg" class="text-center text-muted py-4" style="display: none;">
        No hay más resultados.
    </div>

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
            object-fit: contain;
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

        .btn-ghost-save {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.01));
            color: #f8f9fa;
            border: 1px solid rgba(255, 255, 255, 0.04);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-ghost-save:hover {
            border-color: rgba(0, 200, 255, 0.3);
            background: linear-gradient(90deg, rgba(0, 200, 255, 0.1), rgba(255, 0, 120, 0.05));
            transform: translateY(-1px);
        }

        .btn-ghost-save:active {
            transform: scale(.98);
        }

        .btn-bubbles {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .bubble {
            position: absolute;
            width: 8px;
            height: 8px;
            background: radial-gradient(circle, rgba(0, 200, 255, 0.9), rgba(0, 150, 255, 0.6));
            border-radius: 50%;
            opacity: 0;
            transform: translateY(0) scale(.6);
            filter: blur(1px);
        }

        .btn-ghost-save.saved {
            border-color: rgba(0, 255, 200, .6) !important;
            box-shadow: 0 0 18px rgba(0, 255, 200, .35);
        }

        .form-control-dark,
        .form-select-dark {
            background: rgba(15, 15, 20, 0.8) !important;
            color: #fff !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(10px);
        }

        .form-control-dark:focus,
        .form-select-dark:focus {
            background: rgba(20, 20, 30, 0.9) !important;
            border-color: rgba(0, 200, 255, 0.4) !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 200, 255, 0.1) !important;
            color: #fff !important;
        }

        .form-control-dark::placeholder {
            color: rgba(255, 255, 255, 0.45) !important;
        }

        .global-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.75));
            backdrop-filter: blur(8px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            flex-direction: column;
        }

        .loader-inner {
            text-align: center;
            transform: translateY(-50px);
        }

        .shaker {
            width: 84px;
            height: 84px;
            position: relative;
            margin: 0 auto 20px;
        }

        .shaker-body {
            width: 100%;
            height: 100%;
            border-radius: 14px;
            background: linear-gradient(180deg, #00eaff 0%, #0066ff 100%);
            box-shadow: 0 10px 30px rgba(0, 150, 255, 0.3);
            transform-origin: 50% 60%;
            animation: shaker-sway 1.6s ease-in-out infinite;
        }

        .spark {
            width: 16px;
            height: 16px;
            background: radial-gradient(circle at 30% 30%, #ffffff, rgba(255, 255, 255, 0.8) 20%, rgba(255, 255, 255, 0.0) 60%);
            position: absolute;
            top: 10px;
            left: 16px;
            border-radius: 50%;
            filter: blur(8px);
            animation: sparkle 2s ease-in-out infinite;
        }

        .loader-text {
            color: #00eaff;
            font-size: 1.1rem;
            font-weight: 600;
            margin-top: 15px;
            text-shadow: 0 0 10px rgba(0, 234, 255, 0.5);
        }

        @keyframes shaker-sway {
            0% {
                transform: rotate(-8deg);
            }

            50% {
                transform: rotate(8deg);
            }

            100% {
                transform: rotate(-8deg);
            }
        }

        @keyframes sparkle {

            0%,
            100% {
                opacity: 0.3;
                transform: scale(0.8);
            }

            50% {
                opacity: 1;
                transform: scale(1.2);
            }
        }

        .swal2-container {
            z-index: 10000 !important;
        }

        .sweetalert-popup {
            background: linear-gradient(135deg, rgba(15, 15, 25, 0.98), rgba(10, 10, 20, 0.95)) !important;
            backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 16px !important;
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

        .text-muted {
            color: rgba(255, 255, 255, 0.65) !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(function() {
            let page = 1;
            let loading = false;
            let hasMore = {{ $has_more ? 'true' : 'false' }};

            function getFilters() {
                return {
                    q: $('#q').val().trim(),
                    category: $('#category').val(),
                    alcoholic: $('#alcoholic').val(),
                    sort: $('#sort').val()
                };
            }

            function showGlobalLoader(show = true, text = 'Cargando...') {
                const $loader = $('#globalLoader');
                if (show) {
                    $loader.find('.loader-text').text(text);
                    $loader.css('display', 'flex');
                } else {
                    $loader.hide();
                }
            }

            function createBubbles(btn) {
                const $bubbles = $('<div class="btn-bubbles"></div>');
                const count = 8;

                for (let i = 0; i < count; i++) {
                    const bubble = $('<div class="bubble"></div>');
                    const left = 10 + Math.random() * 80;
                    const size = 4 + Math.random() * 6;

                    bubble.css({
                        left: left + '%',
                        bottom: '0%',
                        width: size + 'px',
                        height: size + 'px',
                        opacity: 0
                    });

                    $bubbles.append(bubble);
                }

                btn.find('.btn-bubbles').remove();
                btn.append($bubbles);

                return $bubbles;
            }

            function animateBubbles($bubbles) {
                $bubbles.find('.bubble').each(function(i, el) {
                    const $bubble = $(el);
                    const delay = i * 100;
                    const duration = 800 + Math.random() * 400;
                    const distance = 30 + Math.random() * 20;

                    $bubble.delay(delay).animate({
                        bottom: '+=' + distance,
                        opacity: 0.8
                    }, duration, 'easeOutCubic').animate({
                        bottom: '+=' + distance,
                        opacity: 0
                    }, duration, 'easeInCubic', function() {
                        $bubble.remove();
                    });
                });
            }

            $(document).on('mouseenter', '.btn-ghost-save', function() {
                if (!$(this).hasClass('saved')) {
                    const $bubbles = createBubbles($(this));
                    animateBubbles($bubbles);
                }
            });

            function renderCards(drinks, append = false) {
                let html = '';
                drinks.forEach(d => {
                    const instr = d.strInstructions ? d.strInstructions.substring(0, 80) :
                        'Sin instrucciones';
                    html += `
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card cocktail-card h-100 shadow-lg text-light" data-id="${d.idDrink}">
                    <div class="media-wrap">
                        <img src="${d.strDrinkThumb}" alt="${escapeHtml(d.strDrink)}" class="media-img">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-1">${escapeHtml(d.strDrink)}</h5>
                        <div class="text-muted small mb-2 d-flex gap-2">
                            <span class="badge neon">${escapeHtml(d.strCategory ?? '—')}</span>
                            <span class="badge bg-secondary">${escapeHtml(d.strAlcoholic ?? '—')}</span>
                        </div>
                        <p class="card-text text-truncate">${escapeHtml(instr)}</p>
                        <div class="mt-auto d-flex gap-2">
                            <button class="btn btn-ghost-save btn-save-cocktail" 
                                data-id="${d.idDrink}"
                                data-name="${escapeHtml(d.strDrink)}"
                                data-category="${escapeHtml(d.strCategory)}"
                                data-alcoholic="${escapeHtml(d.strAlcoholic)}"
                                data-glass="${escapeHtml(d.strGlass)}"
                                data-instructions="${escapeHtml(d.strInstructions)}"
                                data-thumb="${d.strDrinkThumb}">
                                <span class="btn-label"><i class="bi bi-cloud-plus"></i> Guardar</span>
                                <span class="btn-bubbles"></span>
                            </button>
                            <button class="btn btn-outline-light preview-btn" data-drink='${JSON.stringify(d).replace(/'/g,"&#39;")}'>
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>`;
                });

                if (append) {
                    $('#cardsGrid').append(html);
                } else {
                    $('#cardsGrid').html(html);
                    $('html, body').animate({
                        scrollTop: 0
                    }, 150);
                }
            }

            function escapeHtml(text) {
                if (!text && text !== 0) return '';
                return String(text).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g,
                    '&quot;');
            }

            function animateSaveButton(btn) {
                const $bubbles = createBubbles(btn);
                $bubbles.find('.bubble').each(function(i, el) {
                    const $bubble = $(el);
                    const delay = i * 40;
                    $bubble.delay(delay).animate({
                        bottom: '+=50',
                        opacity: 1
                    }, 300, function() {
                        $bubble.animate({
                            bottom: '+=30',
                            opacity: 0
                        }, 400, function() {
                            $bubble.remove();
                        });
                    });
                });
            }

            $(document).on('click', '.btn-save-cocktail', function() {
                const btn = $(this);
                const originalLabel = btn.find('.btn-label').html();
                btn.prop('disabled', true);

                animateSaveButton(btn);
                btn.find('.btn-label').html('<i class="bi bi-cloud-arrow-up"></i> Guardando...');

                showGlobalLoader(true, 'Guardando cóctel...');

                // Extraer ingredientes del data-drink
                const rawDrink = btn.closest('.cocktail-card').find('.preview-btn').data('drink');
                const drink = typeof rawDrink === 'string' ? JSON.parse(rawDrink) : rawDrink;

                // Construir string de ingredientes
                const ingredients = [];
                for (let i = 1; i <= 15; i++) {
                    const ingredient = drink['strIngredient' + i];
                    const measure = drink['strMeasure' + i];

                    if (ingredient && ingredient.trim() !== '') {
                        const ingredientLine = measure ? `${measure} ${ingredient}` : ingredient;
                        ingredients.push(ingredientLine);
                    }
                }
                const ingredientsString = ingredients.join('\n');

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
                        ingredients: ingredientsString // Agregar ingredientes
                    },
                    success: function(res) {
                        btn.find('.btn-label').html('<i class="bi bi-check-lg"></i> Guardado');
                        btn.addClass('saved');

                        // Ocultar el loader primero para que se vea la alerta
                        showGlobalLoader(false);

                        // Mostrar alerta por más tiempo
                        Swal.fire({
                            icon: 'success',
                            title: '¡Guardado!',
                            text: 'El cóctel se agregó a tu colección',
                            timer: 3000,
                            showConfirmButton: false,
                            background: 'linear-gradient(135deg, rgba(15, 15, 25, 0.95), rgba(10, 10, 20, 0.98))',
                            color: '#fff',
                            customClass: {
                                popup: 'sweetalert-popup'
                            }
                        });

                        // Esperar a que el usuario vea la alerta antes de recargar
                        setTimeout(function() {
                            showGlobalLoader(true, 'Actualizando lista...');
                            // Recargar la página para actualizar la lista
                            loadPage(true);
                        }, 2500);
                    },
                    error: function(xhr) {
                        showGlobalLoader(false);
                        console.error('Error al guardar:', xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo guardar el cóctel: ' + (xhr.responseJSON
                                ?.message || 'Error desconocido'),
                            background: 'linear-gradient(135deg, rgba(15, 15, 25, 0.95), rgba(10, 10, 20, 0.98))',
                            color: '#fff',
                            customClass: {
                                popup: 'sweetalert-popup'
                            }
                        });
                        btn.prop('disabled', false);
                        btn.find('.btn-label').html(originalLabel);
                    }
                });
            });

            $(document).on('click', '.preview-btn', function() {
                const raw = $(this).attr('data-drink') || '{}';
                const drink = JSON.parse(raw);

                $('#modalName').text(drink.strDrink || 'Detalle');
                $('#modalThumb').attr('src', drink.strDrinkThumb || '');
                $('#modalCategory').text(drink.strCategory || '—');
                $('#modalAlcoholic').text(drink.strAlcoholic || '—');
                $('#modalGlass').text(drink.strGlass || '—');

                const ingredients = [];
                for (let i = 1; i <= 15; i++) {
                    const name = drink['strIngredient' + i];
                    const meas = drink['strMeasure' + i];
                    if (name) {
                        ingredients.push(`
                            <div class="modal-ingredient">
                                <strong>${name}</strong>${meas ? ` — ${meas}` : ''}
                            </div>
                        `);
                    }
                }
                $('#modalIngredients').html(ingredients.join('') ||
                    '<div class="modal-ingredient">—</div>');

                $('#modalInstructions').text(drink.strInstructions || 'No hay instrucciones disponibles.');

                const modal = new bootstrap.Modal(document.getElementById('drinkModal'), {
                    keyboard: true
                });
                modal.show();
            });

            let filterTimer;
            $('#q, #category, #alcoholic, #sort').on('input change', function() {
                clearTimeout(filterTimer);
                filterTimer = setTimeout(function() {
                    page = 1;
                    hasMore = true;
                    loadPage(true);
                }, 450);
            });

            $('#resetFilters').on('click', function() {
                $('#q').val('a');
                $('#category').val('');
                $('#alcoholic').val('');
                $('#sort').val('');
                page = 1;
                hasMore = true;
                loadPage(true);
            });

            $(document).on('click', '.global-nav', function() {
                showGlobalLoader(true, 'Redirigiendo...');
            });

            function loadPage(replace = false) {
                if (loading) return;
                loading = true;
                showGlobalLoader(true, 'Cargando resultados...');
                $('#endMsg').hide();

                const params = getFilters();
                params.page = page;

                $.get("{{ route('cocktails.api') }}", params)
                    .done(function(data) {
                        if (!data || !data.drinks) {
                            $('#endMsg').show();
                            hasMore = false;
                            return;
                        }
                        renderCards(data.drinks, !replace && page > 1);
                        hasMore = data.has_more;

                        if (!hasMore && page > 1) $('#endMsg').show();
                    })
                    .fail(function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo cargar resultados',
                            background: 'linear-gradient(135deg, rgba(15, 15, 25, 0.95), rgba(10, 10, 20, 0.98))',
                            color: '#fff',
                            customClass: {
                                popup: 'sweetalert-popup'
                            }
                        });
                    })
                    .always(function() {
                        loading = false;
                        showGlobalLoader(false);
                    });
            }

            $(window).on('scroll', function() {
                if (!hasMore || loading) return;
                const nearBottom = $(window).scrollTop() + $(window).height() + 200 >= $(document).height();
                if (nearBottom) {
                    page++;
                    loadPage(false);
                }
            });

        });
    </script>
@endpush
