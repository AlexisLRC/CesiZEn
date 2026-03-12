<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion des Utilisateurs
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6 px-2">
                <h3 class="text-2xl font-bold text-cesi-green">Liste des utilisateurs</h3>
            </div>

            <!-- Filtres -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-6 border-l-4 border-cesi-green">
                <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                    <div>
                        <x-input-label for="search" value="Recherche" />
                        <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" :value="request('search')" placeholder="Nom ou email..." />
                    </div>
                    <div>
                        <x-input-label for="role" value="Rôle" />
                        <select name="role" id="role" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Tous les rôles</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Utilisateur</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="status" value="Statut" />
                        <select name="status" id="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Tous les statuts</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                            <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>Bloqué</option>
                        </select>
                    </div>
                    <div class="flex gap-2 col-span-2">
                        <x-primary-button class="bg-cesi-green hover:bg-green-700">Filtrer</x-primary-button>
                        @if(request()->anyFilled(['search', 'role', 'status', 'sort']))
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
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
                            $sort = request('sort', 'name');
                            $direction = request('direction', 'asc');
                            $nextDirection = $direction === 'asc' ? 'desc' : 'asc';
                        @endphp
                        <thead class="bg-gray-100 text-gray-800 uppercase font-bold">
                            <tr>
                                <th class="px-6 py-4 border-b w-16">Photo</th>
                                <th class="px-6 py-4 border-b">
                                    <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => $sort === 'name' ? $nextDirection : 'asc'])) }}" class="flex items-center hover:text-cesi-green transition">
                                        Nom
                                        @if($sort === 'name')
                                            <span class="ml-1">{!! $direction === 'asc' ? '&#8593;' : '&#8595;' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-4 border-b">
                                    <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort' => 'email', 'direction' => $sort === 'email' ? $nextDirection : 'asc'])) }}" class="flex items-center hover:text-cesi-green transition">
                                        Email
                                        @if($sort === 'email')
                                            <span class="ml-1">{!! $direction === 'asc' ? '&#8593;' : '&#8595;' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-4 border-b">
                                    <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort' => 'role', 'direction' => $sort === 'role' ? $nextDirection : 'asc'])) }}" class="flex items-center hover:text-cesi-green transition">
                                        Rôle
                                        @if($sort === 'role')
                                            <span class="ml-1">{!! $direction === 'asc' ? '&#8593;' : '&#8595;' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-4 border-b">
                                    <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort' => 'is_blocked', 'direction' => $sort === 'is_blocked' ? $nextDirection : 'asc'])) }}" class="flex items-center hover:text-cesi-green transition">
                                        Statut
                                        @if($sort === 'is_blocked')
                                            <span class="ml-1">{!! $direction === 'asc' ? '&#8593;' : '&#8595;' !!}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-4 border-b text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr class="border-b hover:bg-gray-50 transition bg-white">
                                <td class="px-6 py-4">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-800">{{ $user->name }}</td>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    @if($user->id === auth()->id())
                                        <span class="px-2 py-1 rounded text-xs font-bold bg-purple-100 text-purple-800">
                                            {{ strtoupper($user->role) }}
                                        </span>
                                    @else
                                        <form action="{{ route('admin.users.update-role', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" onchange="this.form.submit()" 
                                                class="text-xs font-bold rounded-lg border-transparent focus:ring-0 focus:border-transparent p-1 pr-8 transition cursor-pointer uppercase 
                                                {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }} class="bg-white text-blue-800">USER</option>
                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }} class="bg-white text-red-800">ADMIN</option>
                                            </select>
                                        </form>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->is_blocked)
                                        <span class="px-2 py-1 rounded text-xs font-bold bg-red-100 text-red-800">BLOQUÉ</span>
                                    @else
                                        <span class="px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-800">ACTIF</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 flex justify-center items-center gap-4">
                                    <!-- Bloquer/Débloquer -->
                                    <form action="{{ route('admin.users.toggle-block', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" title="{{ $user->is_blocked ? 'Débloquer' : 'Bloquer' }}" class="p-2 rounded-lg hover:bg-gray-100 transition {{ $user->is_blocked ? 'text-green-600' : 'text-orange-600' }}">
                                            @if($user->is_blocked)
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                            @endif
                                        </button>
                                    </form>

                                    <!-- Supprimer -->
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Supprimer" class="p-2 rounded-lg hover:bg-red-50 text-red-500 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500 italic text-lg bg-white">
                                    Aucun utilisateur ne correspond à vos critères.
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
