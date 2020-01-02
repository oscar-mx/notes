//标记当前文件为 main 包，main 包也是 Go 程序的入口包。
package main

//导入fmt 包，fmt 包实现了格式化 IO（输入/输出）的函数。
import "fmt"

//程序执行的入口函数 main()。
func main() {
	fmt.Println("HELLO")//fmt.Println(...) 可以将字符串输出到控制台，并在最后自动增加换行字符 \n。
}
