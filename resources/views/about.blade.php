<x-guest-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 max-w-4xl mx-auto mt-10">
        <h1 class="text-3xl font-bold text-cesi-green mb-6 text-center">À propos de CesiZen</h1>
        
        <div class="space-y-6 text-gray-700">
            <section>
                <h2 class="text-xl font-bold text-cesi-yellow mb-2">Notre Mission</h2>
                <p>Face à la hausse du stress, CesiZen propose une plateforme souveraine, gratuite et sécurisée. Notre objectif est de démocratiser l'accès aux exercices de cohérence cardiaque et au suivi émotionnel.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-cesi-yellow mb-2">La Cohérence Cardiaque</h2>
                <p>C'est une technique de respiration qui permet de réguler le rythme cardiaque et d'apaiser le système nerveux. Nos exercices (5-5, 4-7-8) sont conçus pour vous guider visuellement.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-cesi-yellow mb-2">Protection des données</h2>
                <p>Conformément au RGPD, vos données restent strictement confidentielles et hébergées en France. Vous disposez d'un droit total de suppression de votre compte via votre profil.</p>
            </section>

            <div class="text-center mt-8">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-cesi-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">
                    Accéder à l'application
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>