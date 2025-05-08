const { defineConfig } = require('@vue/cli-service')
const MiniCssExtractPlugin = require('mini-css-extract-plugin'); 

module.exports = defineConfig({
  transpileDependencies: true,
  chainWebpack: config => {
    config.optimization.splitChunks(false)

    config.output
      .filename('app.js')
      .chunkFilename('app.js');

    config.plugin('extract-css')
      .use(MiniCssExtractPlugin, [{
        filename: 'styles.css',
      }]);
  }
})
