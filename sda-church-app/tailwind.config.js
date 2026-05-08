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
                primary: {
                    DEFAULT: '#2E5F3B', // SDA Brand Green
                    50: '#eff5f1',
                    100: '#d7e6dc',
                    200: '#b1d1be',
                    300: '#83b499',
                    400: '#5c9676',
                    500: '#407b5a',
                    600: '#2e5f3b', // Base
                    700: '#254e32',
                    800: '#1f3e29',
                    900: '#1a3323',
                    950: '#0e1c14',
                },
                secondary: {
                    DEFAULT: '#E3A82B', // SDA Brand Gold
                    50: '#fcf8ec',
                    100: '#f7edce',
                    200: '#efda9e',
                    300: '#e5c366',
                    400: '#e3a82b', // Base
                    500: '#d18b1d',
                    600: '#b46716',
                    700: '#904915',
                    800: '#773a17',
                    900: '#643118',
                    950: '#39170a',
                },
                neutral: {
                    DEFAULT: '#A9AEB1', // SDA Brand Gray
                    50: '#f6f7f7',
                    100: '#eceeef',
                    200: '#d5d9dc',
                    300: '#b3b9bd',
                    400: '#a9aeb1', // Base
                    500: '#737e84',
                    600: '#5c656b',
                    700: '#4b5258',
                    800: '#3f454a',
                    900: '#373a3e',
                    950: '#242729',
                }
            }
        },
    },

    plugins: [forms],
};
