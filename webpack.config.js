const path = require('path');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');

module.exports = {
    entry: path.resolve(__dirname, 'src/index.ts'),
    module: {
        rules: [
            {
                test: /\.(ts|tsx)$/,
                loader: 'ts-loader',
            },
            {
                test: /\.s[ac]ss$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                    },
                    'css-loader',
                    {
                        loader: 'postcss-loader',
                        options: {
                            plugins: () => ([
                                require('autoprefixer'),
                            ]),
                        },
                    },
                    'sass-loader',
                ],
            },
            {
                test: /\.js$/,
                enforce: 'pre',
                loader: 'source-map-loader',
            },
        ],
    },
    resolve: { extensions: [ '.ts', '.tsx', '.js', '.jsx' ] },
    output: {
        filename: 'index.[contenthash].js',
        chunkFilename: '[id].[contenthash].js',
        path: path.resolve(__dirname, 'public/build/'),
        publicPath: '/build/',
    },
    plugins: [
        new CleanWebpackPlugin(),
        new MiniCssExtractPlugin({
            filename: '[name].css',
            chunkFilename: '[id].[contenthash].css',
            ignoreOrder: false,
        }),
        new WebpackManifestPlugin(),
        new HtmlWebpackPlugin({
            filename: '../index.html',
            template: 'src/index.html',
        }),
    ],
};
