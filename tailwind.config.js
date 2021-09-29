const tokens = require('./tailwind-tokens.json');

module.exports = {
  mode: 'jit',
  darkMode: 'media', // or 'media' or 'class'
  prefix: '',
  purge: [
    './views/**/*.{html,twig}',
    './js/**/*.js',
  ],
  theme: {
    colors: tokens.color,
    fontFamily: tokens.font.family,
    fontWeight: tokens.font.weight,
    spacing: tokens.spacer,
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
