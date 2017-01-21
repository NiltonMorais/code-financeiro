var webpack = require('webpack');

module.exports = {
    devtol: 'source-map',
    plugins: [
        new webpack.HotModuleReplacementPlugin()
    ]
};