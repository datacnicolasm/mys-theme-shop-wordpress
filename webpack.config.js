const path = require('path');
const TerserPlugin = require('terser-webpack-plugin');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

module.exports = {
    mode: "production",
    entry: ['./js/src/app.js', './css/src/app.scss'],
    output: {
        filename: './js/build/app.min.js',
        path: path.resolve(__dirname),
        assetModuleFilename: 'assets/img/[hash][name][ext]'
    },
    module: {
        rules: [
            {
                test: /\.js$/, exclude: /node_modules/,
                use: {
                    loader: "babel-loader", 
                    options: { presets: ['@babel/preset-env'] } 
                }
            },
            {
                test: /\.(sass|scss)$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    {
                        loader: "sass-loader",
                        options: {
                            additionalData: `@import "global.scss";`
                        }
                    }
                ]
            },
            {
                test: /\.(png|svg|jpg|jpeg|gif)$/i,
                type: 'asset/resource'
            }

        ]
    },
    resolve: {
        alias: {}
    },
    plugins: [new MiniCssExtractPlugin({ filename: './css/build/main.min.css' }) ],
    optimization: {
        minimize: true,
        minimizer: [
            new TerserPlugin(), 
            new CssMinimizerPlugin()
        ]
    }
};