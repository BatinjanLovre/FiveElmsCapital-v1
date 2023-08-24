const { merge } = require("webpack-merge");
const common = require("./webpack.config");
const TerserPlugin = require("terser-webpack-plugin");

const path = require('path');

module.exports = merge(common, {
    mode: "production",
    module: {
        rules: [
            {
                test:  /\.svg$/,
                loader: 'svg-sprite-loader',
                include:[
                    path.resolve(__dirname, "src/sprites")
                ],
                exclude: [
                    /\.svg\.svg$/
                  ],
            },
        ]
    },
    optimization: {
        minimize: true,
        minimizer: [
            new TerserPlugin()
        ]
    },
});
