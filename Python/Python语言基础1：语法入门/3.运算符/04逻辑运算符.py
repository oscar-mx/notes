# 逻辑运算符
# and	x and y	布尔"与" - 如果 x 为 False，x and y 返回 False，否则它返回 y 的计算值。	(a and b) 返回 20。
# or	x or y	布尔"或" - 如果 x 是 True，它返回 x 的值，否则它返回 y 的计算值。	(a or b) 返回 10。
# not	not x	布尔"非" - 如果 x 为 True，返回 False 。如果 x 为 False，它返回 True。	not(a and b) 返回 False

a = 10
b = 20
 
if ( a and b ):
   print ("1 - 变量 a 和 b 都为 true")
else:
   print ("1 - 变量 a 和 b 有一个不为 true")
 
if ( a or b ):
   print ("2 - 变量 a 和 b 都为 true，或其中一个变量为 true")
else:
   print ("2 - 变量 a 和 b 都不为 true")
 
# 修改变量 a 的值
a = 0
if ( a and b ):
   print ("3 - 变量 a 和 b 都为 true")
else:
   print ("3 - 变量 a 和 b 有一个不为 true")
 
if ( a or b ):
   print ("4 - 变量 a 和 b 都为 true，或其中一个变量为 true")
else:
   print ("4 - 变量 a 和 b 都不为 true")
 
if not( a and b ):
   print ("5 - 变量 a 和 b 都为 false，或其中一个变量为 false")
else:
   print ("5 - 变量 a 和 b 都为 true")

# 输出
# 1 - 变量 a 和 b 都为 true
# 2 - 变量 a 和 b 都为 true，或其中一个变量为 true
# 3 - 变量 a 和 b 有一个不为 true
# 4 - 变量 a 和 b 都为 true，或其中一个变量为 true
# 5 - 变量 a 和 b 都为 false，或其中一个变量为 false

# 非布尔值的与或运算
#   当我们对非布尔值进行与或运算时，Python会将其当做布尔值运算，最终会返回原值
#   与运算的规则
#       与运算是找False的，如果第一个值是False，则不看第二个值
#       如果第一个值是False，则直接返回第一个值，否则返回第二个值
#   或运算的规则
#       或运算是找True的，如果第一个值是True，则不看第二个值
#       如果第一个值是True，则直接返回第一个值，否则返回第二个值    

# True and True
result = 1 and 2 # 2
# True and False
result = 1 and 0 # 0
# False and True
result = 0 and 1 # 0
# False and False
result = 0 and None # 0

# True or True
result = 1 or 2 # 1
# True or False
result = 1 or 0 # 1
# False or True
result = 0 or 1 # 1
# False or False
result = 0 or None # None

print(result)