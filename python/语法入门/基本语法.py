print(1)
# Print(2) 错误写法

# 换行 \
print('11111111111111111111111111111111111111\
2222222222222222')

# 多行注释
# 多行注释
# 多行注释

print(2) # 单行注释

# 变量和标识符 
# 不需要声明，直接赋值使用，不能使用未声明的变量
# print(b) 此处报错 name 'b' is not defined
a = 666 
print(a)

# 可以为变量赋值任意类型，亦可以修改
b = 666 
b = 'hello'
print(b)

# 标识符，可以自主命名的内容属于标识符，如变量名 函数名 类名
_a123 = 123
print(_a123)

# print = 456
# print(print)  报错

# if = 456
# print(if)  报错

aa_bb_cc = 777 # 下划线
HelloWorld = 999 # 大驼峰
print(aa_bb_cc)
print(HelloWorld)