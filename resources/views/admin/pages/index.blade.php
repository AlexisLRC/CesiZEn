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

            <!-- Filtres -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-6 border-l-4 border-cesi-green">
                <form action="{{ route('admin.pages.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <x-input-label for="search" value="Rechercher par titre" />
                        <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" :value="request('search')" placeholder="Titre..." />
                    </div>
                    <div>
                        <x-input-label for="status" value="Statut" />
                        <select name="status" id="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Tous les statuts</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Publiée</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>En attente / Brouillon</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="author" value="Auteur" />
                        <select name="author" id="author" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Tous les auteurs</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <x-primary-button class="bg-cesi-green hover:bg-green-700">Filtrer</x-primary-button>
                        @if(request()->anyFilled(['search', 'status', 'author', 'sort']))
                            <a href="{{ route('admin.pages.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-cesi-green">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        @php
                            $sort = request('sort', 'created_at');
                            $direction = request('direction', 'desc');
                            $nextDirection = $direction === 'asc' ? 'desc' : 'asc';
                        @endphp
                        <thead class="bg-gray-100 text-gray-800 uppercase font-bold">
                            <tr>
                                <th class="px-6 py-4 border-b">
                                    <a href="{{ route('admin.pages.index', array_merge(request()->query(), ['sort' => 'title', 'direction' => $sort === 'title' ? $nextDirection : 'asc'])) }}" class="flex items-center hover:text-cesi-green transition">
                                        Titre
                                        @if($sort === 'title')
                                            <span class="ml-1">{!! $direction === 'asc' ? '&#8593;' : '&#8595;' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-4 border-b">Auteur</th>
                                <th class="px-6 py-4 border-b text-center">
                                    <a href="{{ route('admin.pages.index', array_merge(request()->query(), ['sort' => 'is_published', 'direction' => $sort === 'is_published' ? $nextDirection : 'asc'])) }}" class="flex justify-center items-center hover:text-cesi-green transition">
                                        Statut
                                        @if($sort === 'is_published')
                                            <span class="ml-1">{!! $direction === 'asc' ? '&#8593;' : '&#8595;' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-4 border-b text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pages as $page)
                                <tr class="border-b hover:bg-green-50 transition bg-white">
                                    <td class="px-6 py-4 font-bold text-gray-800 text-lg">{{ $page->title }}</td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-600 italic">
                                            {{ $page->author ? $page->author->name : 'Inconnu' }}
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
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic text-lg bg-white">
                                        Aucune page ne correspond à vos critères de recherche.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
