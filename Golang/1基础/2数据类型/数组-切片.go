package main

import "fmt"

func main(){
	//数组是一个由固定长度的特定类型元素组成的序列，一个数组可以由零个或多个元素组成。
	// Go不允许在数组中混合使用不同类型的元素
	// 数组的长度是固定的，所以在Go语言中很少直接使用数组。
	//arr01 := [...]int{}
	//arr02 := [3]int{}
	//arr03 := [3]int{1,2,3}
	//fmt.Println(arr01,arr02,arr03)
	//fmt.Println(arr03[1])

	//切片（slice）是建立在数组之上的更方便，更灵活，更强大的数据结构。切片并不存储任何元素而只是对现有数组的引用。
	// 切片的构造，有四种方式
	// 1.对数组进行片段截取
	//var a  = [3]int{1, 2, 3}
	//fmt.Println(a[0:1], a[1:3])

	//2.从头声明赋值
	// 声明字符串切片
	//var strList []string
	//// 声明整型切片
	//var numList []int
	//// 声明一个空切片
	//var numListEmpty = []int{}
	//fmt.Println(strList, numList, numListEmpty)
	//// 输出3个切片大小
	//fmt.Println(len(strList), len(numList), len(numListEmpty))

	//3.make函数 make( []Type, size, cap )
	//  Type 是指切片的元素类型，size 指的是为这个类型分配多少个元素，cap 为预分配的元素数量，这个值设定后不影响 size，只是能提前分配空间，降低多次分配空间造成的性能问题。
	a := make([]int, 2)
	b := make([]int, 2, 10)
	fmt.Println(a, b)
	fmt.Println(len(a), len(b))
	fmt.Println(cap(a), cap(b))
}