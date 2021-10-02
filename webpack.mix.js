const mix = require('laravel-mix');

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


const fs = require("fs");

mix.js('resources/js/app.js', 'public/js')
    .copyDirectory('resources/images', 'public/images');

fs.readdirSync('./resources/sass').forEach(file => {
    mix.sass(`resources/sass/${file}`, 'public/css')
        .version()
});
fs.readdirSync('./resources/js/pages').forEach(file => {
    mix.js(`./resources/js/pages/${file}/index.js`, `public/js/page_${file}.js`)
        .version()
});
mix.webpackConfig({
    watchOptions: {
        ignored: /node_modules/
    }
});
