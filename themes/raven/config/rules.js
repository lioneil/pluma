'use strict';

module.exports = [
  /**
   *--------------------------------------------------------------------------
   * Babel Loader
   *--------------------------------------------------------------------------
   *
   */
  {
    test: /\.js$/,
    exclude: /node_modules/,
    use: {
      loader: 'babel-loader',
    },
  },

  /**
   *--------------------------------------------------------------------------
   * Css/Sass Loader
   *--------------------------------------------------------------------------
   *
   * Extract and Minify css/scss/sass files.
   *
   */
  {
    // sass | scss | css
    test: /\.(sa|sc|c)ss$/,
    use: {
      loader: 'css-loader',
    },
  },

];