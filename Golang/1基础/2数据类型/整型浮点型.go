package main

import "fmt"

var myfloat float32 = 1.23
func main()  {
// 不同进制的表示方法
	//%b    表示为二进制
	//%c    该值对应的unicode码值
	//%d    表示为十进制
	//%o    表示为八进制
	//%q    该值对应的单引号括起来的go语法字符字面值，必要时会采用安全的转义表示
	//%x    表示为十六进制，使用a-f
	//%X    表示为十六进制，使用A-F
	//%U    表示为Unicode格式：U+1234，等价于"U+%04X"
	//%E    用科学计数法表示
	//%f    用浮点数表示

	var num int = 10
	var num01 int = 0b1100
	var num02 int = 0o14
	var num03 int = 0xC

	fmt.Printf("10进制数 %d 表示的是: %d \n", num, num)
	fmt.Printf("2进制数 %b 表示的是: %d \n", num01, num01)
	fmt.Printf("8进制数 %o 表示的是: %d \n", num02, num02)
	fmt.Printf("16进制数 %X 表示的是: %d \n", num03, num03)

	fmt.Println("myfloat: ", myfloat)
	fmt.Println("myfloat: ", myfloat+1)

}