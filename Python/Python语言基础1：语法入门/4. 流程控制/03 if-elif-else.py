# if语句
# Python 中用 elif 代替了 else if，所以if语句的关键字为：if – elif – else。
#   1、每个条件后面要使用冒号 :，表示接下来是满足条件后要执行的语句块。
#   2、使用缩进来划分语句块，相同缩进数的语句在一起组成一个语句块。
#   3、在Python中没有switch – case语句。
age = int(input("请输入你的年龄: "))
if age < 0:
    print("你是在逗我吧!")
elif age >= 18:
    print("你成年了！")
elif age <= 18:
    print("你还是个孩子！")
else:
    print("什么操作？！")
### 退出提示
input("点击 enter 键退出")

