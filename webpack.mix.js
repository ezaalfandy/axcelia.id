const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass('resources/dashboard/scss/dashboard.scss', 'public/dashboard/css')
mix.combine(
    [
        'resources/dashboard/js/core/jquery.min.js',
        'resources/dashboard/js/core/popper.min.js',
        'resources/dashboard/js/core/bootstrap.min.js',
        'resources/dashboard/js/plugins/perfect-scrollbar.jquery.min.js',
        'resources/dashboard/js/plugins/jquery.dataTables.min.js',
        'resources/dashboard/js/plugins/jquery.validate.min.js',
        'resources/dashboard/js/plugins/additional-methods.min.js',
        'resources/dashboard/js/plugins/sweetalert2.min.js',
        'resources/dashboard/js/plugins/jquery.bootstrap-wizard.js',
        'resources/dashboard/js/plugins/jasny-bootstrap.min.js',
        'resources/dashboard/js/plugins/bootstrap-selectpicker.js',
        'resources/dashboard/js/plugins/bootstrap-notify.js',
        'resources/dashboard/js/plugins/arrive.min.js',
        'resources/dashboard/js/now-ui-dashboard.js'

    ],
'public/dashboard/js/app.js')

