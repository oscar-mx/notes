## Go变量
### 1.什么是变量
Go语言是静态类型语言，因此`变量有明确类型的`，编译器也会检查变量类型的正确性。从计算机系统实现角度来看，变量是一段或多段用来存储数据的内存。
### 2.Go变量类型
Go语言的基本类型有：
* bool
* string
* int、int8、int16、int32、int64
* uint、uint8、uint16、uint32、uint64、uintptr
* byte // uint8 的别名
* rune // int32 的别名 代表一个 Unicode 码
* float32、float64
* complex64、complex128

### 3.Go变量的声明
Go语言提供了25个关键字和此外，30 多个预定义的名字，比如 int 和 true 等不能作为变量名：

``` go
//关键字
break       default        func         interface        select
case        defer         go           map              struct
chan        else           goto           package          switch
const        fallthrough    if             range            type
continue    for             import        return            var
//预定义字符
true false iota nil

        int int8 int16 int32 int64
        uint uint8 uint16 uint32 uint64 uintptr
        float32 float64 complex128 complex64
        bool byte rune string error

        make len cap new append copy close delete
        complexrealimag
        panic recover
```

同时，当一个Go变量被声明之后，`系统会自动赋零值`：如int为0，bool为false，string为空字符串等。`所有的内存在 Go 中都是经过初始化的。`
变量命名一般使用驼峰式，首个单词小写，后续每个新单词首字母大写，如：helloWorld。

Go使用关键字var声明变量，格式为：
```go
var a int // var 开头，后置变量名 变量类型，结尾无须分号，变量会初始附零值，此处输出0
var b int = 123 // 定义同时并赋值
```
批量声明格式为：
```go
//声明多个变量
     	var a,b int

     	var (
     		c int
     		d string
     		e []float32
     		f func() bool
     		g struct {
     			x int
     		}
     	)
```
简化格式为：
```go
	//简化格式定义变量   名字 := 表达式
	//需要注意的是，简短模式（short variable declaration）有以下限制：
	//定义变量，同时显式初始化。
	//不能提供数据类型。
	//只能用在函数内部。
	a := 123
	b,c:=1, "abc"
	fmt.Println(a,b,c)
```
### 4.GO变量转换
```go
    a, b := 10, 20

    //可以通过多重赋值进行交换
    a, b = b, a

    fmt.Println(a)
    fmt.Println(b)
```

### 5.Go变量作用域
Go语言会在编译时检查每个变量是否使用过，一旦出现未使用的变量，就会报编译错误。

根据变量定义位置的不同，可以分为以下三个类型：
* 函数内定义的变量称为局部变量
* 函数外定义的变量称为全局变量
* 函数定义中的变量称为形参

#### 局部变量
```go
func main() { 
    var a int = 1
    var b int = 2
    //声明局部变量 c 并计算 a 和 b 的和
   //%d是一个占位符 表示输出十进制整数
    c := a + b
    fmt.Printf("a = %d, b = %d, c = %d\n", a, b, c)// 输出a = 1, b = 2, c = 3
}
```
#### 全局变量
函数体外声明的变量称之为全局变量，全局变量只需要在一个文件中定义，就可以在所有文件中使用，不包含这个全局变量的文件需要使用 **import** 关键字引入全局变量所在的源文件之后才能使用这个全局变量。
全局变量声明必须以 **var** 关键字开头，如果想要在外部包中使用全局变量的首字母必须大写。

```go
package main
import "fmt"
//声明全局变量
var c int
func main() {
    c = 10
    fmt.Printf("c = %d\n",c)//输出 c=10
}
```
全局变量与局部变量名称可以相同，但是函数内的局部变量优先级高。

```go
package main
import "fmt"
//声明全局变量
var a float32 = 3.14
func main() {
    //声明局部变量
    var a int = 3
    fmt.Printf("a = %d\n", a)//输出 a=3
}
```

#### 形参
函数名后面括号中的变量叫做形参，形式参数只在函数调用时才会生效，函数调用结束后就会被销毁，在函数未被调用时，形参并不占用实际的存储单元，也没有实际值。

```go
package main
import "fmt"
func main() {
     add(1,2)//输出3
}
func add(s1 int, s2 int) {
    sum := s1 + s2
    fmt.Println(sum)
}

```
