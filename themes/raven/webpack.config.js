'use strict';

// https://www.valentinog.com/blog/webpack-tutorial/

const path = require('path');
const rules = require('./config/rules');
const plugins = require('./config/plugins');

module.exports = {
  cache: true,
  devtool: 'inline-source-map',
  watchOptions: {
    poll: true
  },
  entry: {
    app: './src/app.js',
  },
  output: {
    path: path.resolve(__dirname, 'dist'),
    filename: '[name].min.js',
  },
  resolve: {
    extensions: ['.js', '.json'],
    alias: {
      '@': path.join(__dirname, 'src'),
    },
  },
  module: {
    rules,
  },
  plugins,
}
