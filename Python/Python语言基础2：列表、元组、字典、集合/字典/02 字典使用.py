# 修改字典 
dict = {
    'name': 'mx', 
    'age': 18
    }
print(dict)
dict['age'] = 17 # 更新键age的值
dict['sex'] = 'man' # 添加新的键值对
print(dict)

# 删除字典元素
del dict['sex'] # 删除键sex
print(dict)
dict.clear() # 清空字典
print(dict)

# 字典键的特性

# 不允许同一个键出现两次。创建时如果同一个键被赋值两次，后一个值会被记住
dict = {
    'name': 'mx', 
    'age': 18,
    'age': 19
    }
print(dict)

# 键必须不可变，所以可以用数字，字符串或元组充当，而用列表就不行
# dict1 = {
#     'name': 'mx', 
#     'age': 18,
#     'age': 19,
#     ['name']: 'mx'
#     }
# print(dict1) 
# TypeError: unhashable type: 'list'


