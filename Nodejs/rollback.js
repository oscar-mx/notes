//阻塞 文件读取完后才执行程序
// var fs = require("fs");
//
// var data = fs.readFileSync('input.txt');
//
// console.log(data.toString());
// console.log("程序执行结束!");



//非阻塞 读取文件时同时执行接下来的代码
var fs = require("fs");

fs.readFile('input.txt', function (err, data) {
    if (err) return console.error(err);
    console.log(data.toString());
});

console.log("程序执行结束!");