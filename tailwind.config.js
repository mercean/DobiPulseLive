/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      './resources/views/**/*.blade.php',
      './resources/js/**/*.js',
      "./resources/**/*.vue"
    ],
    darkMode: 'class', // <--- this is important for your dark toggle
    theme: {
      extend: {},
    },
    plugins: [],
  }
  