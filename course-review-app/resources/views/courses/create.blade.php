<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Crear Curso') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form method="POST" action="{{ route('courses.store') }}">
                @csrf

                <div>
                    <x-input-label for="title" value="Título del curso" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="description" value="Descripción" />
                    <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md" rows="4" required></textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="video_url" value="URL del video (opcional)" />
                    <x-text-input id="video_url" name="video_url" type="url" class="mt-1 block w-full" placeholder="https://www.youtube.com/..." />
                    <x-input-error :messages="$errors->get('video_url')" class="mt-2" />
                </div>

                <div class="mt-6">
                    <x-primary-button>Guardar Curso</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
