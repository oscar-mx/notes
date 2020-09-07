'use strict';

/** @type Egg.EggPlugin */
//module.exports = {
  // had enabled by egg
  // static: {
  //   enable: true,
  // }
//};

// 开启视图插件配置
exports.nunjucks = {
    enable: true,
    package: 'egg-view-nunjucks'
};
