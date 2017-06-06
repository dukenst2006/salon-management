const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

    mix.browserSync({
        proxy:'http://shop-management.dev'
    });

    mix.js(['resources/assets/js/salon-sales.js'], 'public/js').sourceMaps();
        //.js(['resources/assets/js/api-dashboard.js'], 'public/js');



   /*.sass('resources/assets/sass/app.scss', 'public/css');*/
