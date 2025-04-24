const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,
  chainWebpack: config => {
    config.optimization.splitChunks(false)

    config.output
      .filename('bundle.js')
      .chunkFilename('bundle.js');
  }
})
