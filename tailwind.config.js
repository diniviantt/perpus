import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/Http/Controllers/*.php",
    ],
    
    theme: {
        container: {
            center: true,
            padding: "24px",
        },
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                box: "0 2px 6px 0 rgba(67, 89, 113, 0.12)",
            },
        },
    },
    plugins: [require("@tailwindcss/forms")],
};
