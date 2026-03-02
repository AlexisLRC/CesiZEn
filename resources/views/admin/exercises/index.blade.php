<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Administration des Exercices
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6 px-2">
                <h3 class="text-2xl font-bold text-cesi-green">Catalogue des exercices</h3>
                <a href="{{ route('admin.exercises.create') }}" class="px-6 py-3 bg-cesi-green text-white font-bold rounded-lg shadow-lg hover:bg-green-700 transition transform hover:scale-105">
                    + Nouvel Exercice
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-cesi-green">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-100 text-gray-800 uppercase font-bold">
                            <tr>
                                <th class="px-6 py-4 border-b w-10"></th> <th class="px-6 py-4 border-b">Nom de l'exercice</th>
                                <th class="px-6 py-4 border-b text-center">Rythme (Inspire / Pause / Expire)</th>
                                <th class="px-6 py-4 border-b text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-table">
                            @foreach($exercises as $exercise)
                            <tr class="border-b hover:bg-green-50 transition cursor-move bg-white" data-id="{{ $exercise->id }}">
                                <td class="px-6 py-4 text-gray-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-800 text-lg">{{ $exercise->name }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs font-bold">{{ $exercise->duration_inhale }}s</span> - 
                                    <span class="bg-gray-200 text-gray-800 py-1 px-3 rounded-full text-xs font-bold">{{ $exercise->duration_hold }}s</span> - 
                                    <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-bold">{{ $exercise->duration_exhale }}s</span>
                                </td>
                                <td class="px-6 py-4 flex justify-center gap-6">
                                    <a href="{{ route('admin.exercises.edit', $exercise) }}" class="text-blue-500 hover:text-blue-700 font-bold hover:underline">Modifier</a>
                                    <form action="{{ route('admin.exercises.destroy', $exercise) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet exercice ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold hover:underline">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var el = document.getElementById('sortable-table');
            var sortable = Sortable.create(el, {
                animation: 150, // Animation fluide
                ghostClass: 'bg-green-100', // Couleur de la ligne quand on la porte
                
                // Fonction déclenchée quand on lâche la ligne
                onEnd: function (evt) {
                    let order = [];
                    // On récupère l'ordre des IDs dans le tableau HTML
                    document.querySelectorAll('#sortable-table tr').forEach(function(row) {
                        order.push(row.dataset.id);
                    });

                    // On envoie le nouvel ordre à Laravel en tâche de fond (AJAX)
                    fetch('{{ route('admin.exercises.reorder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({order: order})
                    });
                }
            });
        });
    </script>
</x-app-layout>