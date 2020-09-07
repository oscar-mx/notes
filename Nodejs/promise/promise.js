// new Promise(function (resolve, reject) {
//     setTimeout(function () {
//         console.log("First");
//         resolve();
//     }, 1000);
// }).then(function () {
//     return new Promise(function (resolve, reject) {
//         setTimeout(function () {
//             console.log("Second");
//             resolve();
//         }, 4000);
//     });
// }).then(function () {
//     setTimeout(function () {
//         console.log("Third");
//     }, 3000);
// });

// promise 构造函数只有一个参数，是一个函数，构造之后会异步运行，这个函数包含两个参数 resolve，reject

// resolve 和 reject 都是函数，其中调用 resolve 代表一切正常，reject 是出现异常时所调用的：

// Promise类有.then().catch()和.finally()三个方法，这三个方法的参数都是一个函数，.
// then()可以将参数中的函数添加到当前Promise的正常执行序列，.
// catch()则是设定Promise的异常处理序列，.
// finally()是在Promise执行的最后一定会执行的序列。 .
// then()传入的函数会按顺序依次执行，有任何异常都会直接跳到catch序列：



//异步函数  async function 中可以使用 await 指令，await 指令后必须跟着一个 Promise，异步函数会在这个 Promise 运行中暂停，直到其运行结束再继续运行。
function print(delay, message) {
    return new Promise(function (resolve, reject) {
        setTimeout(function () {
            console.log(message);
            resolve();
        }, delay);
    });
}

async function asyncFunc() {

    try {
        await print(1000, "First");
        throw  "stop";
        await print(2000, "Second");
        await print(3000, "Third");
    } catch (err) {
        console.log(err);
        // 会输出 Some error
    }
}
asyncFunc();