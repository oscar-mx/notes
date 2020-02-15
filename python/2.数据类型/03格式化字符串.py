# 格式化字符串

# 字符串连接
a = 'abc' + 'def'
print(a)
# 字符串不能和其他类型的值拼接
print('a = ' + a)# 不常用的写法

# 常用写法,可拼接其他类型
a = 123
print('a = ', a)

# 指定占位符
# %s 表示任意字符串
# %f 表示任意浮点数
# %d 表示任意整数
b = 'hello %s'%'world'
b = 'hello %s 你好 %s'%('world','python')
b = 'hello %3.5s'%'world'# %3.5s 表示字符串长度限制在3-5个字符
b = 'hello %.2f'%132.567  #.2f表示取两位小数
b = 'hello %d'%132.5
print(b)

# 通过在字符串前添加f创建格式化字符串，可以直接签入变量
c = f'hello {a} {b}'
print(c)