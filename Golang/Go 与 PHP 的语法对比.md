# Go 与 PHP 的语法对比
> 以下内容摘抄自
>  [原文地址](https://engineering.carsguide.com.au/go-vs-php-syntax-comparison-c1465380b8ff)🙏
>  [译文地址](https://learnku.com/php/t/39590)🙏

![Go 与 PHP 的语法对比](https://cdn.learnku.com/uploads/images/202001/06/9064/YxQ9P52ZUK.png!large)

Go 是由 Google 设计的一门静态类型的编译型语言。它有点类似于 C，但是它包含了更多的优点，比如垃圾回收、内存安全、结构类型和并发性。它的并发机制使多核和网络机器能够发挥最大的作用。这是 GoLang 的最佳卖点之一。此外，Go 速度快，表现力强，干净且高效。这也是 Go 如此吸引开发者学习的原因。

PHP 是一种动态类型语言，它使新手更容易编写代码。现在的问题是，PHP 开发人员能否从动态类型语言切换到像 Go 这样的静态类型语言？为了找到答案，让我们对比一下 Go 和 PHP 之间的语法差异。

## 数据类型

* Go 同时支持有符号和无符号整数，而 PHP 只支持有符号整数。
* 另一个主要区别是数组。Go 对 array 和 map 有单独的类型，而 PHP 数组实际上是有序的 map。
* Go 与 PHP 相比没有对象。但是，Go 有一个类似于 **object** 的 **struct** 类型。

##### PHP 数据类型:
```
boolean
string
integer // Signed integer, PHP does not support unsigned integers.
float (also known as "floats", "doubles", or "real numbers")
array
object
null
resource
```
##### Go 数据类型:
```
string
bool
int  int8  int16  int32  int64 // Signed integer
uint uint8 uint16 uint32 uint64 uintptr // Unsigned integers
byte // alias for uint8
rune // alias for int32
float32 float64
complex64 complex128
array
slices
map
struct
```

## 变量

Go 使用 **var** 声明全局变量和函数变量。但是，它也支持带有初始化程序的简写语法，但只能在函数内部使用。另一方面，PHP 仅支持带有初始化程序的变量声明。

```
// 变量声明
// Go               // PHP
var i int           $i = 0      // integer
var f float64       $f = 0.0    // float
var b bool          $b = false  // boolean
var s string        $s = ""     // string
var a [2]string     $a = []     // array
// 简短的变量声明
// Go                      // PHP
i := 0                     $i = 0      // integer
f := 0.0                   $f = 0.0    // float
b := false                 $b = false  // boolean
s := ""                    $s = ""     // string
a := [1]string{"hello"}    $a = []     // array
```

## 类型转换

```
// Go
i := 42             // Signed integer
f := float64(i)     // Float
u := uint(f)        // Unsigned integer
// PHP
$i = 1;
$f = (float) $i;    // 1.0
$b = (bool) $f      // true
$s = (string) $b    // "1"
```

## 数组

```
// Go
var a [2]string
a[0] = "Hello"
a[1] = "World"
// OR
a := [2]string{"hello", "world"}
// PHP
$a = [
    "hello",
    "world"
];
```

## Maps

```
// Go
m := map[string]string{
    "first_name": "Foo",
    "last_name": "Bar",
}
// PHP
$m = [
    "first_name" => "Foo",
    "last_name" => "Bar"
];
```

## 对象类型
Go 不支持对象。但是，您可以使用 **structs** 实现 **object** 之类的语法。

```
// Go
package main
import "fmt"
type Person struct {
    Name string
    Address string
}
func main() {
    person := Person{"Foo bar", "Sydney, Australia"}
    fmt.Println(person.Name)
}
// PHP
$person = new stdClass;
$person->Name = "Foo bar";
$person->Address = "Sydney, Australia";
echo $person->Name;
// 或使用类型转换
$person = (object) [
    'Name' => "Foo bar",
    'Address' => "Sydney, Australia"
];
echo $person->Name;
```

## 函数
Go 和 PHP 函数之间的主要区别是； Go 函数可以返回任意数量的结果，而 PHP 函数只能返回一个结果。但是，PHP 可以通过返回数组来模拟相同的功能。

```
// Go
package main
import "fmt"
func fullname(firstName string, lastName string) (string) {
    return firstName + " " + lastName
}
func main() {
    name := fullname("Foo", "Bar")
    fmt.Println(name)
}
// PHP
function fullname(string $firstName, string $lastName) : string {
    return $firstName . " " . $lastName;
}
$name = fullname("Foo", "Bar");
echo $name;

// 返回多个结果
// Go
package main
import "fmt"
func swap(x, y string) (string, string) {
    return y, x
}
func main() {
    a, b := swap("hello", "world")
    fmt.Println(a, b)
}
// PHP
// 返回一个数组以获得多个结果
function swap(string $x, string $y): array {
    return [$y, $x];
}
[$a, $b] = swap('hello', 'world');
echo $a, $b;
```
## 流程控制

##### if-else
```
// Go
package main
import (
    "fmt"
)
func compare(a int, b int) {
    if a > b {
        fmt.Println("a is bigger than b")
    } else {
        fmt.Println("a is NOT greater than b")
    }
}
func main() {
    compare(12, 10);
}
// PHP
function compare(int $a, int $b) {
    if ($a > $b) {
        echo "a is bigger than b";
    } else {
        echo "a is NOT greater than b";
    }
}
compare(12, 10);
```
##### switch
Go 的 switch 与 C，C+，Java，JavaScript 和 PHP 中的类似，除了 Go 只运行选中的 case，而不是随后的所有 case。 实际上， **break** 语句在这些语言中的每个 case 后都是必需的，而在 Go 中则是自动补充的。另一个重要的区别是 Go 的 switch cases 不需要是常量，并且涉及的值也不必是整数。
```
// Go
package main
import (
    "fmt"
    "runtime"
)
func main() {
    fmt.Print("Go runs on ")

    os := runtime.GOOS;

    switch os {
    case "darwin":
        fmt.Println("OS X.")
    case "linux":
        fmt.Println("Linux.")
    default:
        fmt.Printf("%s.\n", os)
    }
}
// PHP
echo "PHP runs on ";

switch (PHP_OS) {
    case "darwin":
        echo "OS X.";
        break;
    case "linux":
        echo "Linux.";
        break;
    default:
        echo PHP_OS;
}
```
##### for
```
// Go
package main
import "fmt"
func main() {
    sum := 0

    for i := 0; i < 10; i++ {
        sum += i
    }

    fmt.Println(sum)
}
// PHP
$sum = 0;

for ($i = 0; $i < 10; $i++) {
    $sum += $i;
}
echo $sum;
```
##### while
Go 自身没有 while 循环的语法。相应的，Go 使用 **for** 循环代替实现 while 循环.

```
// Go
package main
import "fmt"
func main() {
    sum := 1

    for sum < 100 {
        sum += sum
    }

    fmt.Println(sum)
}
// PHP
$sum = 1;
while ($sum < 100) {
    $sum += $sum;
}
echo $sum;
```
##### foreach/range
PHP 使用 **foreach** 迭代数组和对象。与之对应，Go 使用 **range** 迭代 slice 或 map。

```
// Go
package main
import "fmt"
func main() {
    colours := []string{"Maroon", "Red", "Green", "Blue"}

    for index, colour := range colours {
        fmt.Printf("index: %d, colour: %s\n", index, colour)
    }
}
// PHP
$colours = ["Maroon", "Red", "Green", "Blue"];

foreach($colours as $index => $colour) {
    echo "index: {$index}, colour: {$colour}\n";
}
```