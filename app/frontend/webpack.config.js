const HtmlWebPackPlugin = require("html-webpack-plugin");

module.exports = {
  entry: {
    app: __dirname + "/src/js/app.jsx"
  },
  devtool: "source-map",
  mode: "development",
  output: {
    filename: '[name].js',
    path: __dirname + '/dist'
  },
  module: {
    rules: [
      {
        test: /\.jsx?$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader"
        }
      },
      {
        test: /\.html$/,
        use: [
          {
            loader: "html-loader"
          }
        ]
      },
      {
        test: /\.css$/i,
        use: ['style-loader', 'css-loader'],
      }
    ]
  },
  devServer: {
    historyApiFallback: true
  },
  resolve: {
      extensions: ['.html', '.js', '.jsx']
  },
  plugins: [
    new HtmlWebPackPlugin({
      template: "./src/index.html"
    })
  ]
};