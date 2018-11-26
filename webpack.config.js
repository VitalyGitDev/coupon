var webpack = require('webpack');
var path = require('path');

var BUILD_DIR = path.join(__dirname, 'public/js');
var APP_DIR = path.join(__dirname, 'assets/js');

var config = {
    entry: APP_DIR + '/index.js',
    output: {
        path: BUILD_DIR,
        filename: 'app.js'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader'
                }
            }
        ]
    }
};

module.exports = config;