{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Panel de Control - Mis Cursos') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Botón crear (solo para quien esté autenticado, ya que dashboard exige auth) --}}
            <div class="flex justify-end mb-4">
                <a href="{{ route('courses.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + Crear nuevo curso
                </a>
            </div>

            {{-- Grid de cursos (MOSTRAMOS TODOS los cursos) --}}
            @if ($courses->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($courses as $course)
                        <div class="border rounded-lg shadow p-4 bg-gray-50 hover:shadow-md transition">
                            <h3 class="text-lg font-bold text-gray-900">{{ $course->title }}</h3>

                            <p class="text-sm text-gray-700 mt-2">
                                <strong>Instructor:</strong> {{ $course->user->name ?? '—' }}
                            </p>

                            <p class="text-sm text-gray-700 mt-2 line-clamp-3">
                                {{ \Illuminate\Support\Str::limit($course->description, 150) }}
                            </p>

                            <div class="mt-4 flex justify-between items-center">
                                {{-- Ver detalles públicos (siempre visible) --}}
                                <a href="{{ route('public.courses.show', $course->id) }}" class="text-blue-600 hover:underline text-sm">
                                    📖 Ver detalles
                                </a>

                                {{-- Si hay video --}}
                                @if ($course->video_url)
                                    <a href="{{ $course->video_url }}" target="_blank" class="text-sm hover:underline">
                                        📺 Ver video
                                    </a>
                                @endif
                            </div>

                            <div class="mt-4 flex justify-between items-center">
                                {{-- Editar solo si el usuario puede --}}
                                @can('update', $course)
                                    <a href="{{ route('courses.edit', $course->id) }}"
                                       class="text-yellow-600 hover:text-yellow-800 font-semibold text-sm">
                                        ✏️ Editar
                                    </a>
                                @else
                                    <span class="text-sm text-gray-500">No puedes editar</span>
                                @endcan

                                {{-- Eliminar solo si el usuario puede --}}
                                @can('delete', $course)
                                    <form method="POST" action="{{ route('courses.destroy', $course->id) }}" onsubmit="return confirm('¿Estás seguro de eliminar este curso?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm">
                                            🗑️ Eliminar
                                        </button>
                                    </form>
                                @else
                                    <span class="text-sm text-gray-500">No puedes eliminar</span>
                                @endcan
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 text-center mt-6">
                    Aún no hay cursos registrados.
                </p>
            @endif

        </div>
    </div>
</x-app-layout>
