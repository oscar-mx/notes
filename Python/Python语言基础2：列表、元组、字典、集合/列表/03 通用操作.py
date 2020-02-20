# 列表对 + 和 * 的操作符与字符串相似。+ 号用于组合列表，* 号用于重复列表。
list1 = [1, 2, 3]
list2 = [4, 5, 6]
list2 = [4, 5, 6, 6]
print(list1 + list2)
print(list1 * 2)

# in 检查元素是否存在于列表中，返回值True/False
# not in 检查元素是否存在于列表中，返回值True/False
print(3 in list1)
print(3 not in list1)

# 列表函数
#	max(list)返回列表元素最大值
#	min(list)返回列表元素最小值
print(max(list1), min(list2))

# 列表元素个数
print(len(list1), len(list2))

# list()用于将元组或字符串转换为列表。
# 注：元组与列表是非常类似的，区别在于元组的元素值不能修改，元组是放在括号中，列表是放于方括号中。
str="Hello World"
list_str=list(str)
print ("列表元素 : ", list_str)

# 列表方法
print(list1.index(2))# 从列表中找出某个值第一个匹配项的索引位置
print(list2.count(6))# 统计某个元素在列表中出现的次数
list2.append('mx')# append() 方法用于在列表末尾添加新的对象。
print ("更新后的列表 : ", list2)

list2.extend(['extend','extend'])# extend() 函数用于在列表末尾一次性追加另一个序列中的多个值（用新列表扩展原来的列表）。
print ("扩展后的列表 : ", list2)

list2.insert(0, '插入索引位置0')# insert() 函数用于将指定对象插入列表的指定位置。0为需要插入的索引位置。
print ("列表插入元素后为 : ", list2)

list2.pop()# pop() 函数用于移除列表中的一个元素（默认最后一个元素），并且返回该元素的值。
print ("列表现在为 : ", list2)
list2.pop(1)# 1为要移除列表元素的索引值，不能超过列表总长度，默认为 index=-1，删除最后一个列表值。
print ("列表现在为 : ", list2)

list2.remove(5)# remove() 函数用于移除列表中某个值的第一个匹配项。
print ("列表现在为 : ", list2)

list2.reverse()# reverse() 函数用于反向列表中元素。
print ("列表反转后: ", list2)

list2_copy = list2.copy()# copy() 函数用于复制列表
print ("list2_copy 列表: ", list2_copy)

list_sort = [6, 5, 4, 8, 9, 7, 3, 6, 2, 1]
list_sort.sort()# sort() 函数用于对原列表进行排序
# 降序
# list_sort.sort(reverse=True)
# 正序
# list_sort.sort(reverse=False)
print ( "排序列表: ", list_sort)

list_sort.clear()# clear() 函数用于清空列表
print ("列表清空后 : ", list_sort)

# for循环遍历输出列表
list1 = [654, 65, 465, 465, 4584, 541351]
for var in list1:
    print('var =', var )



