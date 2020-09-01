var person1 = {
    fullName: function() {
        return this.firstName + " " + this.lastName;
    }
}
var person2 = {
    firstName:"John",
    lastName: "Doe",
}
person1.fullName.call(person2);  // 返回 "John Doe"
// apply 和 call 是函数对象的方法。他们允许切换函数执行的上下文环境（context），即 this 绑定的对象。
// 使用 person2 作为参数来调用 person1.fullName 方法时, this 将指向 person2