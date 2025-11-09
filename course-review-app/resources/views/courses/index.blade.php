@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Lista de Cursos</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('courses.create') }}" class="btn btn-primary mb-3">➕ Crear nuevo curso</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Título</th>
                <th>Instructor</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($courses as $course)
                <tr>
                    <td>{{ $course->title }}</td>
                    <td>{{ $course->instructor }}</td>
                    <td>${{ number_format($course->price, 2) }}</td>
                    <td>
                        <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('courses.destroy', $course) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar curso?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No hay cursos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $courses->links() }}
    </div>
</div>
@endsection
