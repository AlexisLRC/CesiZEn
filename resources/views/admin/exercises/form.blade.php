<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($exercise) ? 'Modifier' : 'Créer' }} un exercice
        </h2>
    </x-slot>

    <div class="py-12 max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-sm sm:rounded-lg">
            <form action="{{ isset($exercise) ? route('admin.exercises.update', $exercise) : route('admin.exercises.store') }}" method="POST">
                @csrf
                @if(isset($exercise)) @method('PUT') @endif

                <div class="mb-4">
                    <label class="block text-gray-700">Nom de l'exercice</label>
                    <input type="text" name="name" value="{{ old('name', $exercise->name ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-cesi-green focus:ring focus:ring-cesi-green focus:ring-opacity-50" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Description</label>
                    <textarea name="description" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $exercise->description ?? '') }}</textarea>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block text-xs uppercase text-gray-500">Inspire (sec)</label>
                        <input type="number" name="duration_inhale" value="{{ old('duration_inhale', $exercise->duration_inhale ?? 5) }}" class="w-full border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="block text-xs uppercase text-gray-500">Pause (sec)</label>
                        <input type="number" name="duration_hold" value="{{ old('duration_hold', $exercise->duration_hold ?? 0) }}" class="w-full border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="block text-xs uppercase text-gray-500">Expire (sec)</label>
                        <input type="number" name="duration_exhale" value="{{ old('duration_exhale', $exercise->duration_exhale ?? 5) }}" class="w-full border-gray-300 rounded-md">
                    </div>
                </div>

                <button type="submit" class="bg-cesi-green text-white px-4 py-2 rounded hover:bg-green-700">
                    Enregistrer
                </button>
            </form>
        </div>
    </div>
</x-app-layout>