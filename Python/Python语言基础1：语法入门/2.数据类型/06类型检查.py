# 类型检查,可以得出指定变量的类型

a = 123
b = '123'
#直接打印无法看出类型
print('a = ',a)
print('b = ',b)
# type() 函数检查变量类型
v = type(a)
print(v)# type()函数返回值 可以看到输出变量类型为 <class 'int'>
print(type(1.5))
print(type('123'))
print(type(True))
print(type(None))
