import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                'brand-dark': '#0b0b0b',
                'brand-gold': '#d4af37',
                'brand-cream': '#faf8f2',
            },
            backgroundColor: {
                'primary': '#0b0b0b',
                'secondary': '#1a1a1a',
                'accent': '#d4af37',
            },
            textColor: {
                'primary': '#ffffff',
                'secondary': '#e5e5e5',
                'accent': '#d4af37',
            },
        },
    },

    plugins: [forms],
};
