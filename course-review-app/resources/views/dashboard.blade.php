<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Panel de Cursos') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('courses.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            + Crear nuevo curso
        </a>

        <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-bold mb-4">Lista de Cursos</h3>

                @if($courses->isEmpty())
                    <p>No hay cursos registrados aún.</p>
                @else
                    <table class="w-full border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Título</th>
                                <th class="px-4 py-2 text-left">Instructor</th>
                                <th class="px-4 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ $course->title }}</td>
                                    <td class="px-4 py-2">{{ $course->instructor }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <a href="{{ route('courses.edit', $course) }}" class="text-blue-600 hover:underline">Editar</a> |
                                        <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('¿Eliminar este curso?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
