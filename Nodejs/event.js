// 引入 events 模块
// var events = require('events');
// // 创建 eventEmitter 对象
// var eventEmitter = new events.EventEmitter();
//
// // 创建事件处理程序
// var connectHandler = function connected() {
//     console.log('连接成功。');
//
//     // 触发 data_received 事件
//     eventEmitter.emit('data_received');
// }
//
// // 绑定 connection 事件处理程序
// eventEmitter.on('connection', connectHandler);
//
// // 使用匿名函数绑定 data_received 事件
// eventEmitter.on('data_received', function(){
//     console.log('数据接收成功。');
// });
//
// // 触发 connection 事件
// eventEmitter.emit('connection');
//
// console.log("程序执行完毕。");

// var EventEmitter = require('events');
// var event = new EventEmitter();
// event.on('some_event', function() {
//     console.log('some_event 事件触发');
// });
// setTimeout(function() {
//     event.emit('some_event');
// }, 1000);

const bar = () => console.log('bar')

const baz = () => console.log('baz')

const foo = () => {
    console.log('foo')
    setTimeout(bar, 0)
    new Promise((resolve, reject) =>
        resolve('应该在 baz 之后、bar 之前')
    ).then(resolve => console.log(resolve))
    baz()
}

foo()