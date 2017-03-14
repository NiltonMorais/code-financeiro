'use strict';

var gulp = require('gulp');
var elixir = require('laravel-elixir');
var webpack = require('webpack');
var WebpackDevServer = require('webpack-dev-server');
var webpackConfig = require('./webpack.config');
var webpackDevConfig = require('./webpack.dev.config');
var mergeWebpack = require('webpack-merge');
var env = require('gulp-env');
var stringifyObject = require('stringify-object');
var file = require('gulp-file');

/*require('laravel-elixir-vue');
require('laravel-elixir-webpack-official');

Elixir.webpack.config.module.loaders = [];

Elixir.webpack.mergeConfig(webpackConfig);
Elixir.webpack.mergeConfig(webpackDevConfig);*/

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

gulp.task('spa-config', function () {
    env({
        file: '.env',
        type: 'ini'
    });
    var spaConfig = require('./spa.config');
    var string = stringifyObject(spaConfig);
    return file('config.js');
});

gulp.task('webpack-dev-server', function () {
    var config = mergeWebpack(webpackConfig, webpackDevConfig);
    var inlineHot = ['webpack/hot/dev-server', 'webpack-dev-server/client?http://localhost:8080'];

    config.entry.admin = [config.entry.admin].concat(inlineHot);
    config.entry.spa = [config.entry.spa].concat(inlineHot);

    new WebpackDevServer(webpack(config), {
        hot: true,
        proxy: {
            '*': 'http://localhost:8000'
        },
        watchOptions: {
            poll: true,
            aggregateTimeout: 300
        },
        publicPath: config.output.publicPath,
        noInfo: true,
        stats: { colors: true }
    }).listen(8080, "0.0.0.0", function () {
        console.log("Bundling project..");
    });
});

elixir(function (mix) {
    mix.sass('./resources/assets/admin/sass/admin.scss').sass('./resources/assets/spa/sass/spa.scss').copy('./node_modules/materialize-css/fonts/roboto', './public/fonts/roboto');

    gulp.start('webpack-dev-server');

    mix.browserSync({
        host: '0.0.0.0',
        proxy: 'http://localhost:8080'
    });
    //.webpack('app.js');
});

//# sourceMappingURL=gulpfile-compiled.js.map