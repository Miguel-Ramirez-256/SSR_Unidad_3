@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center fw-bold">📚 Lista de Cursos</h1>

    @if (session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('courses.create') }}" class="btn btn-primary shadow-sm px-4 py-2">
            ➕ Crear nuevo curso
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle shadow-sm">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>Título</th>
                    <th>Instructor</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($courses as $course)
                    <tr class="text-center">
                        <td>{{ $course->title }}</td>
                        <td>{{ $course->instructor }}</td>
                        <td>${{ number_format($course->price, 2) }}</td>
                        <td class="d-flex justify-content-center gap-2">

                            {{-- 🔵 Ver detalles públicos (reseñas, información, video) --}}
                            <a href="{{ route('public.courses.show', $course->id) }}"
                               class="text-blue-600 hover:underline">
                                👁️ Ver detalles
                            </a>

                            {{-- ✏️ Editar --}}
                            <a href="{{ route('courses.edit', $course) }}"
                               class="btn btn-sm"
                               style="background-color: #ffc107; color: #000; font-weight: 600;">
                                ✏️ Editar
                            </a>

                            {{-- 🗑️ Eliminar --}}
                            <form action="{{ route('courses.destroy', $course) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm"
                                        style="background-color: #dc3545; color: #fff; font-weight: 600;"
                                        onclick="return confirm('¿Seguro que deseas eliminar este curso?')">
                                    🗑️ Eliminar
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            No hay cursos registrados aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($courses->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $courses->links() }}
        </div>
    @endif
</div>
@endsection
