# Python 的元组与列表类似，不同之处在于元组的元素不能修改。
# 元组使用小括号，列表使用方括号。
# 元组创建很简单，只需要在括号中添加元素，并使用逗号隔开即可。
tup1 = (1, 2, 3, 4, 5)
print(type(tup1))
print(tup1)
tup2 = 1, 2, 3, 4, 5 # 不需要括号也可以
print(tup2)

# 元组解包，将元组当中每一个元素都赋值给一个变量
w,a,s,d,f = tup2
print('w = ',w)
print('a = ',a)
print('s = ',s)
print('d = ',d)
print('f = ',f)

# 交换a，b的值，利用元组解包
a = 111
b = 222
print(a,b) # 111 222
a, b = b, a
print(a,b) # 222 111
