var webpack = require('webpack');
var path = require('path');

module.exports = {
    devtol: 'source-map',
    plugins: [
        new webpack.HotModuleReplacementPlugin(),
        new webpack.WatchIgnorePlugin([
            path.resolve(__dirname,'./node_modules)')
        ])
    ]
};