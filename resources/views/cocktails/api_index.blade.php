@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h3 class="mb-0 text-white">Cócteles desde la API</h3>
            <small class="text-muted">Explora, filtra y guarda tus favoritos — estilo Cocktail Bar.</small>
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
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="alcoholic" name="alcoholic" class="form-select form-select-dark">
                        <option value="">Cualquiera</option>
                        @foreach ($filters['alcoholic'] ?? [] as $a)
                            <option value="{{ $a }}">{{ $a }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="sort" name="sort" class="form-select form-select-dark">
                        <option value="">Orden</option>
                        <option value="name_asc">Nombre ↑</option>
                        <option value="name_desc">Nombre ↓</option>
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
            <div class="modal-content bg-dark text-light"
                style="backdrop-filter: blur(6px); border: 1px solid rgba(255,255,255,0.06);">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="drinkModalLabel">Detalle del cóctel</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-5 text-center">
                            <img id="modalThumb" src="" alt="" class="img-fluid rounded"
                                style="max-height:320px; object-fit:contain;">
                        </div>
                        <div class="col-md-7">
                            <h4 id="modalName"></h4>
                            <p class="text-muted mb-1"><strong>Categoría:</strong> <span id="modalCategory"></span></p>
                            <p class="text-muted mb-1"><strong>Tipo:</strong> <span id="modalAlcoholic"></span></p>
                            <p class="text-muted mb-2"><strong>Vaso:</strong> <span id="modalGlass"></span></p>

                            <h6>Ingredientes</h6>
                            <ul id="modalIngredients" class="mb-3" style="list-style: none; padding-left: 0;"></ul>

                            <h6>Instrucciones</h6>
                            <p id="modalInstructions"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
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
            transition: transform .12s ease;
        }

        .btn-ghost-save:active {
            transform: scale(.98);
        }

        .btn-bubbles {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .btn-bubbles .bubble {
            position: absolute;
            width: 8px;
            height: 8px;
            background: rgba(0, 200, 255, 0.9);
            border-radius: 50%;
            opacity: 0;
            transform: translateY(0) scale(.6);
        }

        .btn-ghost-save.saved {
            border-color: rgba(0, 255, 200, .6) !important;
            box-shadow: 0 0 18px rgba(0, 255, 200, .35);
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

        .loader-inner {
            text-align: center;
        }

        .shaker {
            width: 84px;
            height: 84px;
            position: relative;
            margin: 0 auto 12px;
        }

        .shaker-body {
            width: 100%;
            height: 100%;
            border-radius: 14px;
            background: linear-gradient(180deg, #0ff 0%, #06f 100%);
            box-shadow: 0 10px 30px rgba(0, 150, 255, 0.12);
            transform-origin: 50% 60%;
            animation: shaker-sway 1.6s ease-in-out infinite;
        }

        .spark {
            width: 12px;
            height: 12px;
            background: radial-gradient(circle at 30% 30%, #fff, rgba(255, 255, 255, 0.8) 20%, rgba(255, 255, 255, 0.0) 60%);
            position: absolute;
            top: 12px;
            left: 18px;
            border-radius: 50%;
            filter: blur(6px);
        }

        @keyframes shaker-sway {
            0% {
                transform: rotate(-6deg);
            }

            50% {
                transform: rotate(6deg);
            }

            100% {
                transform: rotate(-6deg);
            }
        }

        .modal-content {
            border-radius: 12px;
        }

        .text-muted {
            color: rgba(255, 255, 255, 0.65) !important;
        }

        .form-control-dark,
        .form-select-dark {
            background: rgba(255, 255, 255, 0.02);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.03);
        }

        .form-control-dark::placeholder {
            color: rgba(255, 255, 255, 0.45);
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
                    $loader.stop(true).fadeIn(150);
                } else {
                    $loader.stop(true).fadeOut(150);
                }
            }

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
                const $bubbles = $('<div class="bubble-wrap"></div>');
                const count = 6;
                for (let i = 0; i < count; i++) {
                    const bubble = $('<div class="bubble"></div>');
                    const left = 20 + Math.random() * 60;
                    const top = 10 + Math.random() * 10;
                    bubble.css({
                        left: left + '%',
                        top: top + '%',
                        width: 6 + Math.random() * 8,
                        height: 6 + Math.random() * 8,
                        opacity: 0
                    });
                    $bubbles.append(bubble);
                }
                btn.find('.btn-bubbles').append($bubbles);

                // animate each bubble
                btn.find('.bubble').each(function(i, el) {
                    const delay = i * 40;
                    $(el).delay(delay).animate({
                        top: '-=30',
                        opacity: 1
                    }, 220, function() {
                        $(this).animate({
                            top: '-=20',
                            opacity: 0
                        }, 320, function() {
                            $(this).remove();
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
                    success: function(res) {
                        btn.find('.btn-label').html('<i class="bi bi-check-lg"></i> Guardado');
                        btn.addClass('saved');
                        setTimeout(function() {
                            btn.find('.btn-label').html(originalLabel);
                            btn.removeClass('saved');
                        }, 1400);

                        Swal.fire({
                            icon: 'success',
                            title: 'Guardado',
                            text: 'Cóctel agregado',
                            timer: 1200,
                            showConfirmButton: false
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo guardar el cóctel'
                        });
                    },
                    complete: function() {
                        btn.prop('disabled', false);
                        showGlobalLoader(false);
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

                const ing = [];
                for (let i = 1; i <= 15; i++) {
                    const name = drink['strIngredient' + i];
                    const meas = drink['strMeasure' + i];
                    if (name) ing.push(`<li>${name}${meas ? ' — '+meas : ''}</li>`);
                }
                $('#modalIngredients').html(ing.join('') || '<li>—</li>');
                $('#modalInstructions').text(drink.strInstructions || '—');

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

                        $('#category').val(params.category);
                        $('#alcoholic').val(params.alcoholic);
                        $('#sort').val(params.sort);
                        $('#q').val(params.q);

                        if (!hasMore) $('#endMsg').show();
                    })
                    .fail(function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo cargar resultados'
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
