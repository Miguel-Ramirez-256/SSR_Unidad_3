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

                        {{-- PROMEDIO DEL CURSO --}}
                        @if ($course->reviews_avg_rating)
                            <p class="text-yellow-600 font-semibold">
                                ⭐ {{ number_format($course->reviews_avg_rating, 1) }} / 5
                                ({{ $course->reviews_count ?? $course->reviews->count() }} reseñas)
                            </p>
                        @else
                            <p class="text-gray-500">
                                ⭐ Sin reseñas todavía
                            </p>
                        @endif
                    
                        <p class="text-sm text-gray-700 mt-1">
                            <strong>Instructor:</strong>
                            {{ $course->user->name ?? 'Desconocido' }}
                        </p>

                        <p class="text-gray-600 mt-2">
                            {{ \Illuminate\Support\Str::limit($course->description, 120) }}
                        </p>

                        <div class="mt-3 flex items-center space-x-4">
                            <a href="{{ route('public.courses.show', $course->id) }}"
                                class="text-blue-600 hover:underline inline-block">
                                    📖 Ver detalles
                            </a>

                        @if($course->video_url)
                            <a href="{{ $course->video_url }}" target="_blank" class="text-sm hover:underline inline-block">
                                📺 Ver video
                            </a>
                        @endif
                    </div>
                    </div>
                @endforeach
            </div>

            <div class="flex items-center justify-between mb-6">
                @guest
                <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Volver al login</a>
                @endguest
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
