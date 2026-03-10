<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Administration des Pages d'Information
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6 px-2">
                <h3 class="text-2xl font-bold text-cesi-green">Liste des pages</h3>
                <a href="{{ route('admin.pages.create') }}" class="px-6 py-3 bg-cesi-green text-white font-bold rounded-lg shadow-lg hover:bg-green-700 transition transform hover:scale-105">
                    + Nouvelle Page
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-cesi-green">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-100 text-gray-800 uppercase font-bold">
                            <tr>
                                <th class="px-6 py-4 border-b">Titre</th>
                                <th class="px-6 py-4 border-b">Auteur</th>
                                <th class="px-6 py-4 border-b text-center">Statut</th>
                                <th class="px-6 py-4 border-b text-center">Actions</th>
                            </tr>
                        </thead>
                                <tbody>
                                @foreach($pages as $page)
                                <tr class="border-b hover:bg-green-50 transition bg-white">
                                    <td class="px-6 py-4 font-bold text-gray-800 text-lg">{{ $page->title }}</td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-600 italic">
                                            {{ $page->author ? $page->author->name : 'Administrateur' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($page->is_published)
                                            <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-bold ring-1 ring-green-600/20">Publiée</span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs font-bold ring-1 ring-yellow-600/20">En attente / Brouillon</span>
                                        @endif
                                    </td>
                                <td class="px-6 py-4 flex justify-center gap-6">
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="text-blue-500 hover:text-blue-700 font-bold hover:underline">Modifier</a>
                                    <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette page ?')">
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
</x-app-layout>
