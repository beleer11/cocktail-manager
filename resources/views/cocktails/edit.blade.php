@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="mb-0 text-white">Editar Cóctel</h3>
            <small class="text-white">Modifica la información de tu cóctel guardado.</small>
        </div>
        <div>
            <a href="{{ route('cocktails.stored') }}" class="btn btn-outline-light">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="card shadow-lg bg-dark text-light" style="border: 1px solid rgba(255,255,255,0.03);">
        <div class="card-body">
            <form method="POST" action="{{ route('cocktails.update', $cocktail) }}" class="needs-validation" novalidate
                id="editForm">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-light mb-2">
                                <i class="bi bi-tag me-2"></i>Nombre del cóctel
                            </label>
                            <input type="text" name="name" class="form-control form-control-dark"
                                value="{{ old('name', $cocktail->name) }}" required placeholder="Ej: Margarita, Mojito...">
                            <div class="invalid-feedback">
                                Por favor ingresa un nombre para el cóctel.
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-light mb-2">
                                <i class="bi bi-grid me-2"></i>Categoría
                            </label>
                            <input type="text" name="category" class="form-control form-control-dark"
                                value="{{ old('category', $cocktail->category) }}"
                                placeholder="Ej: Cocktail, Shot, Ordinary Drink...">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label text-light mb-2">
                                <i class="bi bi-droplet me-2"></i>Tipo
                            </label>
                            <select name="alcoholic" class="form-select form-select-dark">
                                <option value="">Seleccionar tipo...</option>
                                <option value="Alcoholic"
                                    {{ old('alcoholic', $cocktail->alcoholic) == 'Alcoholic' ? 'selected' : '' }}>Alcohólico
                                </option>
                                <option value="Non alcoholic"
                                    {{ old('alcoholic', $cocktail->alcoholic) == 'Non alcoholic' ? 'selected' : '' }}>No
                                    alcohólico</option>
                                <option value="Optional alcohol"
                                    {{ old('alcoholic', $cocktail->alcoholic) == 'Optional alcohol' ? 'selected' : '' }}>
                                    Alcohol opcional</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label text-light mb-2">
                                <i class="bi bi-cup-straw me-2"></i>Vaso
                            </label>
                            <input type="text" name="glass" class="form-control form-control-dark"
                                value="{{ old('glass', $cocktail->glass) }}"
                                placeholder="Ej: Highball glass, Cocktail glass...">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label text-light mb-2">
                                <i class="bi bi-image me-2"></i>Imagen URL
                            </label>
                            <input type="url" name="thumbnail" class="form-control form-control-dark"
                                value="{{ old('thumbnail', $cocktail->thumbnail) }}"
                                placeholder="https://ejemplo.com/imagen.jpg">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label text-light mb-2">
                                <i class="bi bi-chat-square-text me-2"></i>Instrucciones
                            </label>
                            <textarea name="instructions" class="form-control form-control-dark" rows="5"
                                placeholder="Describe cómo preparar este cóctel...">{{ old('instructions', $cocktail->instructions) }}</textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label text-light mb-2">
                                <i class="bi bi-list-ul me-2"></i>Ingredientes (uno por línea)
                            </label>
                            <textarea name="ingredients" class="form-control form-control-dark" rows="4"
                                placeholder="Ej: 
- 2 oz Tequila
- 1 oz Lime juice
- 1 oz Triple sec">{{ old('ingredients', $cocktail->ingredients) }}</textarea>
                            <small class="form-text text-muted">Formato: Cantidad + Ingrediente (opcional: medida)</small>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 mt-4 pt-3 border-top border-secondary">
                    <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                        <i class="bi bi-check-lg me-2"></i>Guardar cambios
                    </button>
                    <a href="{{ route('cocktails.stored') }}" class="btn btn-outline-light px-4">
                        <i class="bi bi-x-lg me-2"></i>Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Loader para edición -->
    <div id="editLoader" class="global-loader" style="display:none;">
        <div class="loader-inner">
            <div class="shaker">
                <div class="shaker-body"></div>
                <div class="spark"></div>
            </div>
            <div class="loader-text">Guardando cambios...</div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .form-control-dark,
        .form-select-dark {
            background: rgba(15, 15, 20, 0.8) !important;
            color: #fff !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
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

        .form-label {
            font-weight: 600;
            color: #00eaff !important;
        }

        .form-text {
            font-size: 0.85rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #00eaff, #0066ff);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(0, 234, 255, 0.3);
        }

        .card {
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        /* Loader styles */
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
    </style>
@endpush

@push('scripts')
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        } else {
                            const submitBtn = document.getElementById('submitBtn');
                            submitBtn.disabled = true;
                            submitBtn.innerHTML =
                                '<i class="bi bi-hourglass-split me-2"></i>Guardando...';
                            showEditLoader(true, 'Guardando cambios...');
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        function showEditLoader(show = true, text = 'Guardando cambios...') {
            const $loader = $('#editLoader');
            if (show) {
                $loader.find('.loader-text').text(text);
                $loader.css('display', 'flex');
            } else {
                $loader.hide();
            }
        }

        function submitForm() {
            const form = document.getElementById('editForm');
            const formData = new FormData(form);
            const submitBtn = document.getElementById('submitBtn');

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Guardando...';
            showEditLoader(true, 'Guardando cambios...');

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Actualizado!',
                            text: 'El cóctel se ha actualizado correctamente',
                            timer: 2000,
                            showConfirmButton: false,
                            background: 'linear-gradient(135deg, rgba(15, 15, 25, 0.95), rgba(10, 10, 20, 0.98))',
                            color: '#fff',
                            customClass: {
                                popup: 'sweetalert-popup'
                            }
                        }).then(() => {
                            window.location.href = "{{ route('cocktails.stored') }}";
                        });
                    } else {
                        throw new Error('Error en la actualización');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo actualizar el cóctel',
                        background: 'linear-gradient(135deg, rgba(15, 15, 25, 0.95), rgba(10, 10, 20, 0.98))',
                        color: '#fff',
                        customClass: {
                            popup: 'sweetalert-popup'
                        }
                    });
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Guardar cambios';
                    showEditLoader(false);
                });
        }

        $('input[name="thumbnail"]').on('change', function() {
            const url = $(this).val();
            if (url) {
                console.log('Nueva imagen URL:', url);
            }
        });
    </script>
@endpush
