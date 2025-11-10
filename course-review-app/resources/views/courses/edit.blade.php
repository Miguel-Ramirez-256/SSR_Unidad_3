<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Editar Curso') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Formulario para editar curso --}}
            <form method="POST" action="{{ route('courses.update', $course->id) }}">
                @csrf
                @method('PUT')

                {{-- Título --}}
                <div>
                    <x-input-label for="title" value="Título del curso" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" 
                        value="{{ old('title', $course->title) }}" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                {{-- Descripción --}}
                <div class="mt-4">
                    <x-input-label for="description" value="Descripción" />
                    <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md" rows="4" required>{{ old('description', $course->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                {{-- Instructor --}}
                <div class="mt-4">
                    <x-input-label for="instructor" value="Instructor" />
                    <x-text-input id="instructor" name="instructor" type="text" class="mt-1 block w-full" 
                        value="{{ old('instructor', $course->instructor) }}" required />
                    <x-input-error :messages="$errors->get('instructor')" class="mt-2" />
                </div>

                {{-- URL del video --}}
                <div class="mt-4">
                    <x-input-label for="video_url" value="URL del video (opcional)" />
                    <x-text-input id="video_url" name="video_url" type="url" class="mt-1 block w-full" 
                        placeholder="https://www.youtube.com/watch?v=XXXXX"
                        value="{{ old('video_url', $course->video_url) }}" />
                    <x-input-error :messages="$errors->get('video_url')" class="mt-2" />
                </div>

                {{-- Botones --}}
                <div class="mt-6 flex justify-between">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:underline">
                        ← Volver al panel
                    </a>

                    <x-primary-button>Actualizar Curso</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
