<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.pages.index') }}" class="text-gray-400 hover:text-gray-600 hover:underline">Administration</a>
                <span class="mx-2">/</span>
            @endif
            {{ isset($isProposal) && $isProposal ? 'Proposer un article' : (isset($page->id) ? 'Modifier une page' : 'Créer une page') }}
        </h2>
    </x-slot>

    <div class="py-12 pb-20 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 pb-10 mb-10 shadow-xl sm:rounded-xl border-t-4 border-cesi-yellow overflow-visible">
                
                <h3 class="text-2xl font-bold text-cesi-green mb-2">
                    {{ isset($isProposal) && $isProposal ? 'Nouvelle proposition d\'article' : (isset($page->id) ? 'Modifier : ' . $page->title : 'Nouvelle page d\'information') }}
                </h3>
                
                @if(isset($isProposal) && $isProposal)
                    <p class="text-gray-500 mb-6">Partagez vos connaissances avec la communauté. Votre article sera relu par un administrateur avant d'être publié.</p>
                @endif

                <form action="{{ isset($isProposal) && $isProposal ? route('article.store') : (isset($page->id) ? route('admin.pages.update', $page) : route('admin.pages.store')) }}" method="POST">
                    @csrf
                    @if(isset($page->id) && (!isset($isProposal) || !$isProposal)) @method('PUT') @endif

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Titre de l'article</label>
                        <input type="text" name="title" value="{{ old('title', $page->title ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-cesi-green focus:ring focus:ring-cesi-green focus:ring-opacity-50" placeholder="Ex: Comprendre le stress" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Contenu</label>
                        <textarea name="content" rows="15" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-cesi-green focus:ring focus:ring-cesi-green focus:ring-opacity-50" placeholder="Écrivez votre article ici..." required>{{ old('content', $page->content ?? '') }}</textarea>
                    </div>

                    @if(auth()->user()->role === 'admin')
                    <div class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $page->is_published ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-cesi-green shadow-sm focus:border-cesi-green focus:ring focus:ring-cesi-green focus:ring-opacity-50 w-5 h-5">
                            <span class="ml-3 text-gray-700 font-bold">Publier immédiatement cet article</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-2 ml-8 italic">Si décoché, l'article restera en attente (Brouillon).</p>
                    </div>
                    @endif

                    <div class="flex justify-end gap-4 mt-8">
                        <a href="{{ auth()->user()->role === 'admin' ? route('admin.pages.index') : route('informations') }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition">Annuler</a>
                        <button type="submit" class="px-6 py-3 bg-cesi-green text-white font-bold rounded-lg shadow-lg hover:bg-green-700 transition transform hover:scale-105">
                            {{ isset($isProposal) && $isProposal ? 'Envoyer pour relecture' : (isset($page->id) ? 'Mettre à jour' : 'Créer l\'article') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
