<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon Profil') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-l-4 border-cesi-green">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-l-4 border-cesi-yellow">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl text-center mx-auto">
            <p class="text-sm text-gray-600">
                {{ __('Besoin d\'aide ou une question ? Contactez-nous à l\'adresse suivante :') }}
            </p>
            <a href="mailto:CesizenAlr@gmail.com" class="text-lg font-bold text-indigo-600 hover:text-indigo-900 hover:underline transition ease-in-out duration-150">
                 CesizenAlr@gmail.com
            </a>
        </div>
    </div>
</x-app-layout>