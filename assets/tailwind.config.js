/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["../app/View/**/*.php"],
  theme: {
    extend: {
      colors: { navy: { 900: '#0F2C59', 800: '#183B70' } },
    },
  },
  plugins: [],
};
