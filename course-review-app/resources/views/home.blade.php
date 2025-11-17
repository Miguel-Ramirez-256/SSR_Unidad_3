{{-- resources/views/home.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">

        <h1 class="text-3xl font-bold mb-6 text-gray-900">
            Lista de Cursos
        </h1>

        @if($courses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach($courses as $course)
                    <div class="p-6 bg-white shadow rounded-lg border border-gray-200">

                        {{-- Título --}}
                        <h2 class="text-xl font-semibold text-gray-900">
                            {{ $course->title }}
                        </h2>

                        {{-- Instructor --}}
                        <p class="text-sm text-gray-700 mt-1">
                            <strong>Instructor:</strong>
                            {{ $course->instructor }}
                        </p>

                        {{-- Descripción resumida --}}
                        <p class="text-gray-600 mt-2">
                            {{ Str::limit($course->description, 120) }}
                        </p>

                        {{-- Botón Ver Detalles (USANDO SLUG) --}}
                        <a href="{{ route('public.courses.show', $course->id) }}" 
                            class="text-blue-600 hover:underline mt-3 inline-block">
                            Ver detalles
                        </a>

                    </div>
                @endforeach

            </div>

            {{-- Paginación --}}
            <div class="mt-6">
                {{ $courses->links() }}
            </div>

        @else
            <p class="text-gray-500">No hay cursos disponibles.</p>
        @endif

    </div>
</x-app-layout>
