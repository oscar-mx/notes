package main

import . "fmt"

const (
	name = "meng"
	age = "18"
)

// iota 生成器，类似枚举
// 首先定义一个 Weekday 命名类型，然后为一周的每天定义了一个常量，从周日 0 开始 周一为 1，以此类推。
type Weekday int

const (
	Sunday Weekday = iota
	Monday
	Tuesday
	Wednesday
	Thursday
	Friday
	Saturday
)

func main (){
	// 常量是在编译时被创建的，即使定义在函数内部也是如此，并且只能是布尔型、数字型（整数型、浮点型和复数）和字符串

	const(
		pi = 3.1415926
	)
	Println(name)
	Println(age)
	Println(getConstStr(name))
	Println(getConstStr(age))

	Println(pi)
}

func getConstStr(b string)  string{
	return b
}
