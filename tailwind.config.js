import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            colors: {
                primary: {
                    900: "#0a0a0a",
                    800: "#1a1a1a",
                    700: "#2d2d2d",
                    600: "#404040",
                    500: "#525252",
                },
                accent: {
                    orange: "#ff6b35",
                    darkOrange: "#e55a2b",
                    lightOrange: "#ff8c5a",
                    red: "#d63031",
                    darkRed: "#c4231f",
                    lightRed: "#e84444",
                },
            },
        },
    },

    plugins: [forms, typography],
};
