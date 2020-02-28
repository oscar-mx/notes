<?php
/**
 * hset() 为哈希表中一个字段赋值
 * 参数：
    * key: string
    * hashkey: string
    * value: string
 * 返回值 int/false: 如果字段是哈希表中的一个新建字段，并且值设置成功，返回 1 。 如果哈希表中字段已经存在且旧值已被新值覆盖，返回 0 。出错时返回FALSE
 */
    $redis->delete('h');
    $redis->hSet('h', 'key1', 'hello'); // 返回 1，'key1` => 'hello'
    $redis->hGet('h', 'key1'); // 返回 'hello'

    $redis->hSet('h', 'key1', 'plop'); // 替换字段值，返回 0
    $redis->hGet('h', 'key1'); // 返回 'plop'

/**
 * hSetNx() 在字段不存在时，设置哈希字段的值
 * 返回值 boolean: 成功返回TRUE，字段已存在则返回FALSE
 */
    $redis->delete('h');
    $redis->hSetNx('h', 'key1', 'hello'); // TRUE
    $redis->hSetNx('h', 'key1', 'world'); // FALSE

/**
 * hGet() 获取哈希中指定字段的值，如果哈希表或者key不存在，返会FALSE
 * 参数 key: string；hashKey: string
 * 返回值 string/boolean: 成功时返回字段的值，失败返回FALSE
 */

/**
 * hLen() 获取哈希表中字段的数量
 * 参数 key: string
 * 返回值 int: 哈希表中字段的数量，如果key不存在或非哈希表，返回FALSE
 */
    $redis->del('h');
    $redis->hSet('h', 'key1', 'hello');
    $redis->hSet('h', 'key2', 'plop');
    $redis->hLen('h'); // 返回 2

/**
 * hDel() 删除一个或多个哈希表字段，如果哈希表或字段不存在，返回FALSE
 * 参数 key: string；hashKey1: string；hashKey2: string；...
 * 返回值 int/boolean: 被删除的字段数量，key不存在时返回 0，key非哈希则返回FALSE
 */

 /**
 * hKeys() 获取哈希表中所有字段名，返回字符串数组
 * 参数 key: string
 * 返回值 array: 哈希表中所有字段名称组成的数组，类似PHP中的array_keys()
 */

    $redis->del('h');
    $redis->hSet('h', 'a', 'x');
    $redis->hSet('h', 'b', 'y');
    $redis->hSet('h', 'c', 'z');
    $redis->hSet('h', 'd', 't');
    var_dump($redis->hKeys('h'));
    /* 返回
    array(4) {
        [0]=>
        string(1) "a"
        [1]=>
        string(1) "b"
        [2]=>
        string(1) "c"
        [3]=>
        string(1) "d"
    }
    tips：顺序是随机的，并且对应于redis自己对集合结构的内部表示。
    */

/**
 * hVals() 获取哈希表中所有值，返回字符串数组
 * 参数 key:string
 * 返回值 array: 哈希表中所有字段值组成的数组，类似PHP中的array_values()
 */
    $redis->del('h');
    $redis->hSet('h', 'a', 'x');
    $redis->hSet('h', 'b', 'y');
    $redis->hSet('h', 'c', 'z');
    $redis->hSet('h', 'd', 't');
    var_dump($redis->hVals('h'));
    /* 返回
    array(4) {
        [0]=>
        string(1) "x"
        [1]=>
        string(1) "y"
        [2]=>
        string(1) "z"
        [3]=>
        string(1) "t"
      }
      tips：顺序是随机的，并且对应于redis自己对集合结构的内部表示。
      */

/**
 * hGetAll() 获取哈希表中所有字段和值
 * 参数 key:string
 * 返回值 array: 关联数组，哈希表的字段名称为键名，字段值为键值
 */
    $redis->delete('h');
    $redis->hSet('h', 'a', 'x');
    $redis->hSet('h', 'b', 'y');
    $redis->hSet('h', 'c', 'z');
    $redis->hSet('h', 'd', 't');
    var_dump($reids->hGetAll('h'));
    /* 返回
    array(4) {
    ["a"]=>
    string(1) "x"
    ["b"]=>
    string(1) "y"
    ["c"]=>
    string(1) "z"
    ["d"]=>
    string(1) "t"
    }
    */

/**
 * hExists() 查看哈希表中指定字段是否存在
 * 参数 key: string；memberKey: string
 * 返回值 boolean: 若哈希表中，指定字段存在，返回TRUE，否则返回FALSE
 */
    $redis->hSet('h', 'a', 'x');
    $redis->hExists('h', 'a'); /*  TRUE */
    $redis->hExists('h', 'NonExistingKey'); /* FALSE */

/**
 * hIncrBy() 为哈希表中指定字段值加上增量；增量也可以为负数，相当于对给定域进行减法操作。
 * 参数 key: string；member: string；value: int 字段的增量
 * 返回值 int: 自增后的字段值
 */
    $redis->delete('h');
    $redis->hIncrBy('h', 'x', 2); // 返回 2，h[x] = 2
    $redis->hIncrBy('h', 'x', 1); // h[x] = 2 + 1，返回 2

/**
 * hIncByFloat() 为哈希表中指定字段值加上增量浮点值，和 hIncrBy() 同理
 * 参数 key: string；member: string；value: float 字段的增量
 * 返回值 float: 自增后的字段值
 */

/**
 * hMSet() 为哈希表中的多个字段同时赋值，非字符串值转换为字符串，NULL转化为空字符串
 * 参数 key: string；members: array key => value数组
 * 返回值 boolean
 */
    $redis->hMSet('user1', ['name' => 'xxx', 'age' => 18]);


/**
 * hMGet() 获取所有给定字段的值
 * 参数 key: string；memberKeys : array
 * 返回值 boolean
 */
    $redis->hMSet('user1', ['name', 'age']); // 返回 ['name' => 'xxx', 'age' => 18]


/**
 * hStrLen() 获取哈希表中字段值的长度
 * 参数 key: string；field: string
 * 返回值 int: 字段值的长度，哈希表或字段不存在时，返回 0
*/


/**
 * hScan() 迭代哈希表中的键值对
 * 参数 
    * key: string
    * iterator: int 迭代次数的引用
    * pattern: string 可选，匹配模式
    * count: int 每次返回的字段数
 * 返回值 array: 与给定模式匹配的元素组成的数组
 */
    $it = NULL;
    /* 在完成迭代之前，不要返回空数组 */
    $redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY);
    while($arr_keys = $redis->hScan('hash', $it)) {
        foreach($arr_keys as $str_field => $str_value) {
            echo "$str_field => $str_value\n"; /* 输出哈希成员和值 */
        }
    }








