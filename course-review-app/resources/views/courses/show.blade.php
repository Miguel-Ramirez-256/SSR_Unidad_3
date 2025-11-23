<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

            {{-- Mensajes flash --}}
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-3 bg-yellow-100 text-yellow-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Errores de validación --}}
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 text-red-700 rounded">
                    <ul class="list-disc ps-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- TÍTULO --}}
            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $course->title }}</h1>

            {{-- PROMEDIO --}}
            @if ($course->reviews_avg_rating)
                <p class="text-yellow-600 font-semibold mb-4">
                    ⭐ {{ number_format($course->reviews_avg_rating, 1) }} / 5
                    ({{ $course->reviews_count ?? $course->reviews->count() }} reseñas)
                </p>
            @else
                <p class="text-gray-500 mb-4">
                    ⭐ Este curso aún no tiene reseñas
                </p>
            @endif

            {{-- INSTRUCTOR --}}
            <p class="text-gray-600 mb-4">
                <strong>Instructor:</strong> {{ $course->user->name ?? 'Desconocido' }}
            </p>

            {{-- DESCRIPCIÓN --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Descripción</h3>
                <p class="text-gray-700 leading-relaxed">
                    {{ $course->description }}
                </p>
            </div>

            {{-- VIDEO --}}
            @if($course->video_url)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Video del curso</h3>

                    <div class="aspect-w-16 aspect-h-9">
                        <iframe 
                            class="w-full h-96 rounded-md border"
                            src="{{ str_replace('watch?v=', 'embed/', $course->video_url) }}"
                            frameborder="0"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            @endif

            {{-- FORMULARIO DE RESEÑA --}}
            <div class="border-t pt-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Agregar reseña</h3>

                @auth
                    <form action="{{ route('reviews.store', $course->id) }}" method="POST" class="space-y-4">
                        @csrf

                        {{-- Calificación --}}
                        <div>
                            <label class="block font-semibold mb-1">Calificación (1–5):</label>

                            <div class="relative inline-block">
                                <select name="rating" class="w-40 border rounded p-2 pr-8 appearance-none">
                                    <option value="">Selecciona</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>

                                {{-- SVG flecha a la derecha --}}
                                <div class="pointer-events-none absolute inset-y-0 end-0 flex items-center pe-2">
                                    <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>

                            @error('rating')
                                <p class="text-red-700 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Comentario --}}
                        <div>
                            <label class="block font-semibold mb-1">Comentario:</label>
                            <textarea 
                                name="comment"
                                rows="6"
                                class="w-full border rounded p-2"
                                placeholder="Escribe tu opinión...">{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="text-red-700 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Botones: enviar y volver --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-2">
                            <div>
                                <button 
                                    type="submit"
                                    class="px-4 py-2 bg-blue-600 text-black rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                    Agregar reseña
                                </button>
                            </div>
                        </div>
                    </form>
                @endauth

                @guest
                    <p class="text-gray-600">
                        Debes 
                        <a href="{{ route('login') }}" class="text-blue-600 underline">iniciar sesión</a>
                        para dejar una reseña.
                    </p>
                @endguest
            </div>

            {{-- RESEÑAS --}}
            <div class="mt-10">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Reseñas del curso</h3>

                @if ($course->reviews->count() == 0)
                    <p class="text-gray-600">Aún no hay reseñas. ¡Sé el primero en opinar!</p>
                @endif

                <div class="space-y-4">
                    @foreach ($course->reviews->sortByDesc('created_at') as $review)
                        <div class="border rounded p-4 bg-gray-50">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold">
                                        ⭐ {{ $review->rating }} / 5
                                    </p>
                                    <p class="mt-2">{{ $review->comment }}</p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Por: {{ $review->user->name ?? 'Usuario' }} • {{ $review->created_at->diffForHumans() }}
                                    </p>
                                </div>

                                @can('delete', $review)
                                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="ms-4">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            class="text-red-600 hover:underline text-sm"
                                            onclick="return confirm('¿Eliminar reseña?')">
                                            🗑️ Eliminar
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- BOTONES --}}
            <div class="flex justify-between mt-10">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:underline">
                        ← Volver al panel
                    </a>

                    @can('update', $course)
                        <a href="{{ route('courses.edit', $course->id) }}" class="text-blue-600 font-semibold hover:underline">
                            Editar curso
                        </a>
                    @endcan
                @endauth
            </div>

        </div>
    </div>
</x-app-layout>
