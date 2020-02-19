# while循环
# while 判断条件(condition)：
#    执行语句(statements)……
# 如果condition为true，执行statements，再次执行循环，如果condition为false，终止循环
#a = 1
#while a < 10:
#    print(a)
#    a += 1

# while 循环使用 else 语句，在 while … else 在条件语句为 false 时执行 else 的语句块。
a = 1
while a < 5:
    print(a,'< 5')
    a += 1
else:
    print(a,'= 5')