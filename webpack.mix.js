import mix from 'laravel-mix';

mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
      (await import('postcss-import')).default,
      (await import('tailwindcss')).default,
      (await import('autoprefixer')).default
   ]);