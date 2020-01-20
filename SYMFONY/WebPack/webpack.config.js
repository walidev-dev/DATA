var Encore = require('@symfony/webpack-encore');
Encore
// directory where compiled assets will be stored
    .setOutputPath('web/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    .addEntry('app', './assets/js/app.js')
    .addEntry('script', './assets/js/script.js')

    .enableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())

    .enableVersioning(Encore.isProduction());



module.exports = Encore.getWebpackConfig();