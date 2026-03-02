import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                cesi: {
                    green: '#00ab55',  // Le vert du logo (approximatif)
                    yellow: '#fcd34d', // Le jaune du logo
                    dark: '#1f2937',   // Gris foncé pour le texte
                },
            },
        },
    },

    plugins: [forms],
};
