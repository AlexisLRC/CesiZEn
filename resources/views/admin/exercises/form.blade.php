<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('admin.exercises.index') }}" class="text-gray-400 hover:text-gray-600 hover:underline">Administration</a>
            <span class="mx-2">/</span>
            {{ isset($exercise) ? 'Modifier un exercice' : 'Créer un exercice' }}
        </h2>
    </x-slot>

    <div class="py-12 pb-20 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 pb-10 mb-10 shadow-xl sm:rounded-xl border-t-4 border-cesi-yellow overflow-visible">
                
                <h3 class="text-2xl font-bold text-cesi-green mb-6">
                    {{ isset($exercise) ? 'Modifier : ' . $exercise->name : 'Nouvel exercice de respiration' }}
                </h3>

                <form action="{{ isset($exercise) ? route('admin.exercises.update', $exercise) : route('admin.exercises.store') }}" method="POST">
                    @csrf
                    @if(isset($exercise)) @method('PUT') @endif

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Nom de l'exercice</label>
                        <input type="text" name="name" value="{{ old('name', $exercise->name ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-cesi-green focus:ring focus:ring-cesi-green focus:ring-opacity-50" placeholder="Ex: Cohérence Express" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Description</label>
                        <textarea name="description" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-cesi-green focus:ring focus:ring-cesi-green focus:ring-opacity-50" placeholder="Expliquez les bienfaits de cet exercice...">{{ old('description', $exercise->description ?? '') }}</textarea>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-6">
                        <p class="text-sm text-gray-500 font-bold uppercase mb-4 text-center tracking-widest">Configuration du rythme (en secondes)</p>
                        <div class="grid grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm text-center text-blue-600 font-bold mb-2">Inspiration</label>
                                <input type="number" name="duration_inhale" value="{{ old('duration_inhale', $exercise->duration_inhale ?? 5) }}" class="w-full border-gray-300 rounded-lg text-center shadow-sm" min="1" max="60" required>
                            </div>
                            <div>
                                <label class="block text-sm text-center text-gray-600 font-bold mb-2">Apnée (Pause)</label>
                                <input type="number" name="duration_hold" value="{{ old('duration_hold', $exercise->duration_hold ?? 0) }}" class="w-full border-gray-300 rounded-lg text-center shadow-sm" min="0" max="60" required>
                            </div>
                            <div>
                                <label class="block text-sm text-center text-green-600 font-bold mb-2">Expiration</label>
                                <input type="number" name="duration_exhale" value="{{ old('duration_exhale', $exercise->duration_exhale ?? 5) }}" class="w-full border-gray-300 rounded-lg text-center shadow-sm" min="1" max="60" required>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 mt-8">
                        <a href="{{ route('admin.exercises.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition">Annuler</a>
                        <button type="submit" class="px-6 py-3 bg-cesi-green text-white font-bold rounded-lg shadow-lg hover:bg-green-700 transition">
                            {{ isset($exercise) ? 'Mettre à jour' : 'Créer l\'exercice' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>