<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Administration des Exercices
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('admin.exercises.create') }}" class="mb-4 inline-block px-4 py-2 bg-cesi-green text-white rounded hover:bg-green-700">
            + Nouvel Exercice
        </a>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <table class="min-w-full text-left text-sm font-light">
                <thead class="border-b font-medium bg-gray-100">
                    <tr>
                        <th class="px-6 py-4">Nom</th>
                        <th class="px-6 py-4">Rythme (Inspire/Pause/Expire)</th>
                        <th class="px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exercises as $exercise)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="whitespace-nowrap px-6 py-4 font-bold">{{ $exercise->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4">
                            {{ $exercise->duration_inhale }} - {{ $exercise->duration_hold }} - {{ $exercise->duration_exhale }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 flex gap-2">
                            <a href="{{ route('admin.exercises.edit', $exercise) }}" class="text-blue-600 hover:underline">Modifier</a>
                            <form action="{{ route('admin.exercises.destroy', $exercise) }}" method="POST" onsubmit="return confirm('Sur ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>