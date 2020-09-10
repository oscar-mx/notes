package main

import . "fmt"

func main(){
	// 相同底层类型的变量之间可以进行相互转换

	a1 := 3.1415926
	a2 := int(a1)
	Println(a1,a2)
	// 不同底层类型的变量相互转换时会引发编译错误
	// cannot convert b1 (type int) to type bool
	//b1 := 1
	//b2 := bool(b1)
	//Println(b1,b2)

}
