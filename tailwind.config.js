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
            colors: {
                primary: '#B24B4B',
                pinkbg: '#FFF0F0', // Background pink muda
            },
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            borderRadius: {
                'xl': '15px', // Border radius 15px untuk card
            },
            boxShadow: {
                'halus': '0 4px 20px -2px rgba(0, 0, 0, 0.05)', // Shadow halus untuk card
            }
        },
    },

    plugins: [forms],
};