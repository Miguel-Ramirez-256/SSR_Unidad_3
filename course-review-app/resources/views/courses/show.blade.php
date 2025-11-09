{{-- resources/views/courses/show.blade.php --}}
<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        {{-- Título del curso --}}
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
            {{ $course->title }}
        </h1>

        {{-- Descripción del curso --}}
        <p class="text-gray-700 text-lg mb-6">
            {{ $course->description ?? 'Sin descripción disponible.' }}
        </p>

        <hr class="my-6">

        {{-- Reseñas --}}
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
            Reseñas de este curso
        </h2>

        @if($course->reviews->count() > 0)
            <div class="space-y-4">
                @foreach($course->reviews as $review)
                    <div class="bg-white border border-gray-200 shadow rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <p class="font-semibold text-gray-800">
                                {{ $review->user->name }}
                            </p>
                            <span class="text-yellow-500">
                                ⭐ {{ $review->rating }}/5
                            </span>
                        </div>
                        <p class="text-gray-700">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Aún no hay reseñas para este curso.</p>
        @endif

        {{-- Zona para Fase 4: formulario de reseña (solo autenticados) --}}
        @auth
            <hr class="my-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Deja tu reseña</h3>
            <form action="{{ route('reviews.store', $course) }}" method="POST" class="space-y-4">
                @csrf

                {{-- Calificación --}}
                <div>
                    <label for="rating" class="block font-medium text-gray-700">Calificación (1 a 5)</label>
                    <input type="number" name="rating" id="rating" min="1" max="5" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                {{-- Comentario --}}
                <div>
                    <label for="comment" class="block font-medium text-gray-700">Comentario</label>
                    <textarea name="comment" id="comment" rows="3" required
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>

                <x-primary-button>Enviar reseña</x-primary-button>
            </form>
        @endauth

        @auth
        <form method="POST" action="{{ route('reviews.store', $course) }}">
            @csrf
            <!-- input rating, textarea comment -->
            </form>
            @else
            <a href="{{ route('login') }}">Inicia sesión para dejar una reseña</a>
            @endauth
    </div>
</x-app-layout>
