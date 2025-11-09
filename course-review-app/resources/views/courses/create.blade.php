<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear nuevo curso
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('courses.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="title" value="Título" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="description" value="Descripción" />
                        <textarea id="description" name="description" class="block w-full border-gray-300 rounded-md" rows="3" required></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="instructor" value="Instructor" />
                        <x-text-input id="instructor" name="instructor" type="text" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('instructor')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="price" value="Precio (MXN)" />
                        <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>Guardar curso</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
