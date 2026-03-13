<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Configurer Mon Exercice</h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-xl sm:rounded-xl border-t-4 border-cesi-yellow">
                <form action="{{ route('personal.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-3 gap-6 mb-8">
                        <div>
                            <label class="block text-sm text-center text-blue-600 font-bold mb-2">Inspiration</label>
                            <input type="number" name="duration_inhale" value="{{ $exercise->duration_inhale ?? 5 }}" class="w-full border-gray-300 rounded-lg text-center" min="1" max="60" required>
                        </div>
                        <div>
                            <label class="block text-sm text-center text-gray-600 font-bold mb-2">Apnée</label>
                            <input type="number" name="duration_hold" value="{{ $exercise->duration_hold ?? 0 }}" class="w-full border-gray-300 rounded-lg text-center" min="0" max="60" required>
                        </div>
                        <div>
                            <label class="block text-sm text-center text-green-600 font-bold mb-2">Expiration</label>
                            <input type="number" name="duration_exhale" value="{{ $exercise->duration_exhale ?? 5 }}" class="w-full border-gray-300 rounded-lg text-center" min="1" max="60" required>
                        </div>
                    </div>
                    <button type="submit" class="w-full py-3 bg-cesi-yellow text-white font-bold rounded-lg shadow-lg hover:bg-yellow-500 transition">Enregistrer mon rythme</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>