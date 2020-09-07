//引入了当前目录下的 hello.js 文件（./ 为当前目录，node.js 默认后缀为 js）。
// var hello = require('./hello');
// hello.oscar();

var Hello = require('./hello');
hello = new Hello();
hello.setName('oscar');
hello.sayHello();