import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                "orange-red-gradient":
                    "linear-gradient(175deg, #ffba00 0, #ffa900 8.33%, #ff9500 16.67%, #ff7d00 25%, #ff6300 33.33%, #ff4300 41.67%, #ff1200 50%, #ed0018 58.33%, #dc0023 66.67%, #cc002c 75%, #be0035 83.33%, #b1003e 91.67%, #a60047 100%)",
            },
        },
    },

    plugins: [forms],
};
