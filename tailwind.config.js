const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

<<<<<<< HEAD

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'), require("daisyui")],

    daisyui: {
        themes: [
          {
            mytheme: {
                "base-100":"#ffffff",
                "base-200":"#047857",
                "base-300":"#C8E9DF",
            },
          },
          "dark",
          "cupcake",
        ],
      },

=======
    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'), require("daisyui")],
>>>>>>> main
};



