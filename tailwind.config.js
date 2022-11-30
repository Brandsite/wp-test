module.exports = {
  content: require('fast-glob').sync(['./**/*.php', './src/**/*.js']),
  theme: {
    fontFamily: {
      sans: ['Arsenal', 'sans'],
    },
    extend: {},
  },
  plugins: [],
};
