# 集合（set）是一个无序的不重复元素序列。
# 可以使用大括号 { } 或者 set() 函数创建集合，注意：创建一个空集合必须用 set() 而不是 { }，因为 { } 是用来创建一个空字典。
s = set()# 空集合
print(type(s),s)
s = {1,2,3} 
print(type(s),s)
s = {1,2,3,1,2,3,4} 
print(type(s),s)# 重复值会被去掉
# TypeError: unhashable type: 'list'
# s = {[1,2,3],1,2,3,4} 
# print(type(s),s)
a = set('abcedfg')
print(a)