var path    = require('path');
var hwp     = require('html-webpack-plugin');
var webpack = require('webpack');

module.exports = {
    watch: true,
    watchOptions: {
        aggregateTimeout: 300,
        poll: 1000,
        ignored: ['node_modules']
    },
    entry: path.join(__dirname, '/src/index.js'),
    output: {
        filename: 'build.js',
        path: path.join(__dirname, '/application/static/dist')
    },
    module:{
        rules:[{
            exclude: /node_modules/,
            test: /\.js$/,
            loader: 'babel-loader',
            query: {
                presets: ['react', 'es6'],
                plugins: ['transform-class-properties']
            }
        }]
    },
    plugins:[
        new hwp({template:path.join(__dirname, '/src/index.html')}),
        new webpack.DefinePlugin({
            "process.env": { 
               NODE_ENV: JSON.stringify("development") 
             }
          })
    ]
}