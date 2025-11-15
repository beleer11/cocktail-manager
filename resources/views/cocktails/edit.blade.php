@extends('layouts.app')

@section('content')
    <h3 class="mb-4">Editar Cóctel</h3>

    <form method="POST" action="{{ route('cocktails.update', $cocktail) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input name="name" class="form-control" value="{{ $cocktail->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <input name="category" class="form-control" value="{{ $cocktail->category }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <input name="alcoholic" class="form-control" value="{{ $cocktail->alcoholic }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Vaso</label>
            <input name="glass" class="form-control" value="{{ $cocktail->glass }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Instrucciones</label>
            <textarea name="instructions" class="form-control">{{ $cocktail->instructions }}</textarea>
        </div>

        <button class="btn btn-primary">Guardar cambios</button>
    </form>
@endsection
