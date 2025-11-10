<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Título --}}
            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $course->title }}</h1>

            {{-- Instructor --}}
            <p class="text-gray-600 mb-4">
                <strong>Instructor:</strong> {{ $course->instructor }}
            </p>

            {{-- Descripción --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Descripción</h3>
                <p class="text-gray-700 leading-relaxed">
                    {{ $course->description }}
                </p>
            </div>

            {{-- Video (si existe) --}}
            @if($course->video_url)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Video del curso</h3>
                    <div class="aspect-w-16 aspect-h-9">
                        <iframe 
                            class="w-full h-96 rounded-md border"
                            src="{{ str_replace('watch?v=', 'embed/', $course->video_url) }}"
                            title="Video del curso"
                            frameborder="0"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            @endif

            {{-- Botones --}}
            <div class="flex justify-between mt-8">
                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:underline">
                    ← Volver al panel
                </a>

                @can('update', $course)
                    <a href="{{ route('courses.edit', $course->id) }}" class="text-blue-600 font-semibold hover:underline">
                        ✏️ Editar curso
                    </a>
                @endcan
            </div>

        </div>
    </div>
</x-app-layout>
