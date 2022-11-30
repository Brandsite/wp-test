module.exports = {
  content: require('fast-glob').sync(['./**/*.php', './src/**/*.js']),
  theme: {
    fontFamily: {
      sans: ['Arsenal', 'sans'],
      poiret: ['Poiret One', 'sans'],
      playfair: ['Playfair display', 'sans'],
    },

    extend: {},
  },
  plugins: [],
};
