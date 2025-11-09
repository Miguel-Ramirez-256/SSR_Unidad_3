@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Crear nuevo curso</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups!</strong> Corrige los errores antes de continuar.
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('courses.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Instructor</label>
            <input type="text" name="instructor" class="form-control" value="{{ old('instructor') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="number" name="price" class="form-control" step="0.01" value="{{ old('price') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Guardar curso</button>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
