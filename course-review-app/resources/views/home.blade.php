{{-- resources/views/home.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Lista de Cursos</h1>

        @if($courses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($courses as $course)
                    <div class="p-6 bg-white shadow rounded-lg border border-gray-200">
                        <h2 class="text-xl font-semibold">{{ $course->title }}</h2>
                        <p class="text-gray-600 mt-2">{{ $course->description ?? 'Sin descripción' }}</p>
                        <a href="{{ route('courses.show', $course) }}" class="text-blue-600 hover:underline mt-3 inline-block">
                            Ver detalles
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $courses->links() }}
            </div>
        @else
            <p class="text-gray-500">No hay cursos disponibles.</p>
        @endif
    </div>
</x-app-layout>
