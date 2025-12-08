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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'pakistan-green': {
                    50: '#f0f9f4',
                    100: '#dcf2e3',
                    200: '#bce4ca',
                    300: '#8fcea8',
                    400: '#5ab07d',
                    500: '#36915a',
                    600: '#277348',
                    700: '#205c3b',
                    800: '#1c4a31',
                    900: '#183e29',
                    950: '#0c2316',
                },
            },
        },
    },

    plugins: [forms],
};
