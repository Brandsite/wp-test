let mix = require('laravel-mix');

mix
  .sass('src/scss/app.scss', '/assets/dist')
  .postCss('src/css/app.css', '/assets/dist', [
    require('tailwindcss'),
    require('autoprefixer'),
  ])
  .js('src/js/front', 'assets/dist/js')

  .options({
    processCssUrls: false,
  })
  .disableSuccessNotifications();
