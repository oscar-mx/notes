package main

import "fmt"
//1. 一行声明一个变量
//var name string = "mengxiang"

//2. 多个变量一起声明
//var (
//	name string  = "mengxiang"
//	num  float32 = 0.01
//)



func getData() (string,string){
	return "hello","world"
}
func main() {
	//3.声明并初始化，只能用于函数内部
	//name := "mengxiang"

	//4.声明初始化多个变量，只能用于函数内部
	//name, age := "mengxiang", 18
	//fmt.Println(name,age)

	//5.指针变量
	//age := 18
	//var addr = &age // &后面接变量名，表示取出该变量的内存地址
	//fmt.Println("age: ", age)
	//fmt.Println("addr: ", addr)

	//addr := new(int)
	//fmt.Println("addr 地址:",addr)
	//fmt.Println("addr 值:",*addr) // * 后面接指针变量，表示从内存地址中取出值

	//6.匿名变量不占用内存空间，不会分配内存。匿名变量与匿名变量之间也不会因为多次声明而无法使用。
	a, _ := getData() // 只需要获取第一个返回值，所以将第二个返回值的变量设为下画线（匿名变量）。
	_, b := getData()// 将第一个返回值的变量设为匿名变量。
	fmt.Println(a,b)
}

