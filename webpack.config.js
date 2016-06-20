var webpack = require('webpack');

module.exports =  {
  entry: [
    './app/Resources/public/js/es6/player.js'
  ],
  output: {
    path: "/web/frontend/js/",
    publicPath: "/web/frontend/",
    filename: "app.js"
  },
  watch: false,
  module: {
    loaders: [
      {
        test: /\.js$/,
        // excluding some local linked packages.
        // for normal use cases only node_modules is needed.
        exclude: /node_modules/,
        loader: 'babel'
      },
      {
        test: /\/src\/.*\.js$/,
        loaders: [
          'closure-loader'
        ],
        exclude: [/node_modules/, /test/]
      },
      {
        test: /\.scss$/,
        loaders: ['style', 'css', 'sass']
      },

      {
        test: /\.vue$/,
        loader: 'vue'
      }
    ]
  },
  babel: {
    presets: ['es2015'],
    plugins: ['transform-runtime']
  },
  resolve: {
    modulesDirectories: ['node_modules']
  }
  ,
  closureLoader: {
    paths: [
      __dirname + '/vendor/friendsofsymfony/jsrouting-bundle/'
    ],
    es6mode: true,
    watch: true
  }
}
