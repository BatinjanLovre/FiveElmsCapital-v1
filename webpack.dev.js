const { merge } = require("webpack-merge");
const common = require("./webpack.config");
const path = require('path');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');


module.exports = merge(common, {
    mode: "development",
    plugins: [
        new BrowserSyncPlugin({
            proxy: "localhost/start_praksa",
            files: [ path.resolve(__dirname, "assets/css") + '/*.css' ],
            injectCss: true,
          }, { reload: false, }),
    ],
    watch: true,
    module: {
        rules: [
            /////IMAGES
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

});

