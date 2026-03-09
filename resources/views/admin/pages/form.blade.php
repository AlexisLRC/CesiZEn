<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('admin.pages.index') }}" class="text-gray-400 hover:text-gray-600 hover:underline">Administration</a>
            <span class="mx-2">/</span>
            {{ isset($page) ? 'Modifier une page' : 'Créer une page' }}
        </h2>
    </x-slot>

    <div class="py-12 pb-20 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 pb-10 mb-10 shadow-xl sm:rounded-xl border-t-4 border-cesi-yellow overflow-visible">
                
                <h3 class="text-2xl font-bold text-cesi-green mb-6">
                    {{ isset($page) ? 'Modifier : ' . $page->title : 'Nouvelle page d\'information' }}
                </h3>

                <form action="{{ isset($page) ? route('admin.pages.update', $page) : route('admin.pages.store') }}" method="POST">
                    @csrf
                    @if(isset($page)) @method('PUT') @endif

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Titre de la page</label>
                        <input type="text" name="title" value="{{ old('title', $page->title ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-cesi-green focus:ring focus:ring-cesi-green focus:ring-opacity-50" placeholder="Ex: Comprendre le stress" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Contenu (HTML possible)</label>
                        <textarea name="content" rows="15" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-cesi-green focus:ring focus:ring-cesi-green focus:ring-opacity-50" placeholder="Contenu de la page..." required>{{ old('content', $page->content ?? '') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $page->is_published ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-cesi-green shadow-sm focus:border-cesi-green focus:ring focus:ring-cesi-green focus:ring-opacity-50">
                            <span class="ml-2 text-gray-700 font-bold">Publier la page</span>
                        </label>
                    </div>

                    <div class="flex justify-end gap-4 mt-8">
                        <a href="{{ route('admin.pages.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition">Annuler</a>
                        <button type="submit" class="px-6 py-3 bg-cesi-green text-white font-bold rounded-lg shadow-lg hover:bg-green-700 transition">
                            {{ isset($page) ? 'Mettre à jour' : 'Créer la page' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
