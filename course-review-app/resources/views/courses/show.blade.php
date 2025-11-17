<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-600 font-semibold rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- TÍTULO --}}
            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $course->title }}</h1>

            {{-- INSTRUCTOR --}}
            <p class="text-gray-600 mb-4">
                <strong>Instructor:</strong> {{ $course->user->name }}
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
                <form action="{{ route('reviews.store', $course->id) }}" method="POST">
                    @csrf

                    {{-- Calificación --}}
                    <div>
                        <label class="block font-semibold mb-1">Calificación (1–5):</label>
                        <select name="rating" class="w-32 border rounded p-2">
                            <option value="">Selecciona</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        @error('rating')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Comentario --}}
                    <div>
                        <label class="block font-semibold mb-1">Comentario:</label>
                        <textarea 
                            name="comment"
                            rows="4"
                            class="w-full border rounded p-2">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button 
                        type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Agregar reseña
                    </button>
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
                            <div class="flex justify-between">
                                <p class="font-semibold">
                                    ⭐ {{ $review->rating }} / 5  
                                </p>

                                @can('delete', $review)
                                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST">
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

                            <p class="mt-2">{{ $review->comment }}</p>

                            <p class="text-sm text-gray-500 mt-1">
                                Por: {{ $review->user->name }} • {{ $review->created_at->diffForHumans() }}
                            </p>
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
