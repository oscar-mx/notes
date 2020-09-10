package main

import . "fmt"

func main() {
	a1 := true
	a2 := false

	b1 := 1
	b2 := 0
	Println(bool_to_int(a1), bool_to_int(a2))
	Println(int_to_bool(b1), int_to_bool(b2))

}

// 布尔值不会隐式转换为数字值 0 或 1，反之亦然，必须使用 if 语句显式的进行转换：

func bool_to_int(b bool) int {
	if b {
		return 1
	}
	return 0
}

func int_to_bool(b int) bool {
	if b == 1 {
		return true
	} else if b == 0 {
		return false
	}
	return false
}
