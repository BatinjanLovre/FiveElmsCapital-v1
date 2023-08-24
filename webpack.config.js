const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const IgnoreEmitPlugin = require('ignore-emit-webpack-plugin');

const path = require('path');
const SpriteLoaderPlugin = require('svg-sprite-loader/plugin');
//const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;


var webpack = require('webpack');


module.exports = {
    entry: {
        index: './src/js/index.js',
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "../css/style.min.css"
        }),

        new SpriteLoaderPlugin({
            plainSprite: true
        }),
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery",
            'window.jQuery': 'jquery'
        })
    ],
    output: {
        filename: 'script.min.js',
        path: path.resolve(__dirname, 'assets/js'),
        clean: true,
    },
    module: {
        rules: [
            {
                test: /\.(css|scss)$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    "css-loader",
                    "postcss-loader",
                    "sass-loader"
                ],
            },
            {
                test: /\.(js|jsx)$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                      presets: ['@babel/preset-env']
                    }
                }
                
            }
        ]
    },

};