/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./src/**/*.{html,js,php}", "./public/**/*.{html,js,php}", "./node_modules/flowbite/**/*.js"],
    theme: {
      theme: {
        colors: {
          transparent: 'transparent',
          current: 'currentColor',
          'white': '#ffffff',
          'purple': '#3f3cbb',
          'midnight': '#121063',
          'metal': '#565584',
          'tahiti': '#3ab7bf',
          'silver': '#ecebff',
          'bubble-gum': '#ff77e9',
          'bermuda': '#78dcca',
        },
      },
      extend: {},
    },
    plugins: [
        require('flowbite/plugin')
    ],
  }
  