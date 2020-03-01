<?php
// Redis列表是简单的字符串列表，按照插入顺序排序。你可以添加一个元素到列表的头部（左边）或者尾部（右边）
// 一个列表最多可以包含 232 - 1 个元素 (4294967295, 每个列表超过40亿个元素)。

/**
 * blPop() brPop() 移出并获取列表的第一个/最后一个元素， 如果列表没有元素会阻塞列表直到等待超时或发现可弹出元素为止
 * 参数：
    *keys: array 包含列表中key的数组
    *timeout: int 超时时间
    *或
    *key-1: string
    *key-2: string
    *key-3: string
    *...
    *key-n: string
    *timeout: int 超时时间
 * 返回值 array: array('listName', 'element')
 */
    // 非阻塞
    $redis->lPush('key1', 'A');
    $redis->delete('key2');

    $redis->blPop('key1', 'key2', 10); // array('key1', 'A')
    // 或
    $redis->blPop(['key1', 'key2'], 10); // array('key1', 'A')

    $redis->brPop('key1', 'key2', 10); // array('key1', 'A');
    // 或
    $redis->brPop(['key1', 'key2'], 10); // array('key1', 'A')

    // 阻塞
    // 进程 1
    $redis->delete('key1');
    $redis->blPop('key1', 10); // 阻塞 10s

    // 进程 2
    $redis->lPush('key1', 'A');

    // 进程 1
    // 返回 array('key1', 'A')

/**
 * bRPopLPush() rPopLPush的阻塞版本，从列表中弹出一个值，将弹出的元素插入到另外一个列表中并返回它； 如果列表没有元素会阻塞列表直到等待超时或发现可弹出元素为止。
 * 参数 srcKey: string，dstKey: string，timeout: int 超时时间
 * 返回值 string/boolean: 返回被移除的元素，等待超时则返回FALSE
 */

 /**
 * rPopLPush() 移除列表的最后一个元素，并将该元素添加到另一个列表并返回
 * 参数 srcKey: string，dstKey: string
 * 返回值 string: 返回被移除的元素。失败返回FALSE
 */
    $redis->delete('x', 'y');

    $redis->lPush('x', 'abc');
    $redis->lPush('x', 'def');
    $redis->lPush('y', '123');
    $redis->lPush('y', '456');

    var_dump($redis->rPopLPush('x', 'y'));
    var_dump($redis->lRange('x', 0, -1));
    var_dump($redis->lRange('y', 0, -1));
    /*
    输出
    string(3) "abc"
    array(1) {
    [0]=>
    string(3) "def"
    }
    array(3) {
    [0]=>
    string(3) "abc"
    [1]=>
    string(3) "456"
    [2]=>
    string(3) "123"
    }
    */

/**
 * lIndex() 通过索引获取列表中的元素
 * 参数 key: string，index: int
 * 返回值 string/boolean: 返回指定索引处的元素。如果索引对应的元素不存在，或非字符串类型，返回FALSE
 */
    $redis->rPush('key1', 'A');
    $redis->rPush('key1' ,'B');
    $redis->rPush('key1', 'C'); // key1 => ['A', 'B', 'C']
    $redis->lindex('key1', 0); // 'A'
    $redis->lindex('key1', -1); // 'C'
    $redis->lindex('key1', 10); // FALSE

/**
 * lInset() 在列表的元素前或者后插入元素，当列表不存在，或指定元素不存在与列表中时，不执行任何操作
 * 将值 value 插入到列表 key 当中，位于值 pivot 之前或之后。
 * 当 pivot 不存在于列表 key 时，不执行任何操作。
 * 当 key 不存在时， key 被视为空列表，不执行任何操作。
 * 如果 key 不是列表类型，返回一个错误。
 * 参数 ：
    * key: string
    * position: string Redis::BEFORE | Redis::AFTER
    * pivot: string
    * value: string
 * 返回值 int: 返回插入操作完成之后，列表的长度。如果没有找到指定元素，返回 -1
 */
    $redis->delete('key1');
    $redis->lInsert('key1', Redis::AFTER, 'A', 'X'); // 0

    $redis->lPush('key1', 'A');
    $redis->lPush('key1', 'B');
    $redis->lPush('key1', 'C');

    $redis->lInsert('key1', Redis::BEFORE, 'C', 'X'); // 4
    $redis->lRange('key1', 0, -1); // array('A', 'B', 'X', 'C')

    $redis->lInsert('key1', Redis::AFTER, 'C', 'Y'); // 5
    $redis->lRange('key1', 0, -1); // array('A', 'B', 'X', 'C', 'Y')

    $redis->lInsert('key1', Redis::AFTER, 'W', 'value'); // -1

/**
 * lPop() 移出并获取列表的第一个元素
 * 参数 key: string
 * 返回值 string/boolean: 返回列表的第一个元素，失败时(空列表)返回FALSE
 */
    $redis->rPush('key1', 'A');
    $redis->rPush('key1', 'B');
    $redis->rPush('key1', 'C'); // key1 => ['A', 'B', 'C']
    $redis->lPop('key1'); // key1 => ['B', 'C']

/**
 * lPush() 将一个或多个值 value 按从左到右的顺序依次插入到列表 key 的表头,如果key不存在，一个空列表会被创建并执行lPush操作。当key存在但不是列表类型时，返回FALSE
 * 参数 key: string，value: string 要插入到列表中的字符串
 * 返回值 int: 返回执行插入操作后，列表的长度。失败时返回FALSE
 */

    $redis->delete('key1');
    $redis->lPush('key1', 'C'); // 返回 1
    $redis->lPush('key1', 'B'); // 返回 2
    $redis->lPush('key1', 'A'); // 返回 3
    // key1 现在指向列表: ['A', 'B', 'C']

/**
 * lPushX() 将一个值插入到已存在的列表头部，当 key 不存在时， LPUSHX 命令什么也不做。
 * 参数 key: string，value: string 要插入到列表中的字符串
 * 返回值 int: 返回执行插入操作后，列表的长度。失败时返回FALSE
 */
    $redis->delete('key1');
    $redis->lPushX('key1', 'A'); // 返回 0
    $redis->lPush('key1', 'A'); // 返回 1
    $redis->lPushX('key1', 'B'); // 返回 2
    $redis->lPushX('key1', 'C'); // 返回 3
    // key1 现在指向列表: ['A', 'B', 'C']

/**
 * lRange()返回列表中指定区间内的元素，区间以偏移量start和end指定。
 * 其中 0 表示列表的第一个元素， 1 表示列表的第二个元素...
 * 以 -1 表示列表的最后一个元素， -2 表示列表的倒数第二个元素... 以此类推
 * 参数 key: string，start: int，end: int
 * 返回值  array: 包含指定区间内元素的数组
 */
    $redis->rPush('key1', 'A');
    $redis->rPush('key1', 'B');
    $redis->rPush('key1', 'C');
    $redis->lRange('key1', 0, -1); // array('A', 'B', 'C')
/**
 * lRem() 根据参数count的值，移除列表中与参数value相等的元素。
 * 如果count = 0，移除表中所有与value相等的值；
 * 如果count < 0，从表尾开始向表头搜索，移除与value相等的元素，数量为count的绝对值；
 * 如果count > 0，从表头开始向表尾搜索，移除与value相等的元素，数量为count
 * 参数 key: string，value: string，count: int
 * 返回值  int/boolean: 返回被移除元素的数量。列表不存在时返回FALSE
 */
    $redis->lPush('key1', 'A');
    $redis->lPush('key1', 'B');
    $redis->lPush('key1', 'C');
    $redis->lPush('key1', 'A');
    $redis->lPush('key1', 'A');

    $redis->lRange('key1', 0, -1); // array('A', 'A', 'C', 'B', 'A')
    $redis->lRem('key1', 'A', 2); // 2
    $redis->lRange('key1', 0, -1); // array('C', 'B', 'A')

/**
 * lSet() 通过索引设置列表元素的值
 * 参数 key: string，index: int，value: string
 * 返回值 boolean: 操作成功返回TRUE。如果索引超出范围，或者key不指向列表，返回FALSE
 */
    $redis->rPush('key1', 'A');
    $redis->rPush('key1', 'B');
    $redis->rPush('key1', 'C'); // key1 => ['A', 'B', 'C']
    $redis->lGet('key1', 0); // 'A'
    $redis->lSet('key1', 0, 'X');
    $redis->lGet('key1', 0); // 'X'

/**
 * lTrim() 对一个列表进行修剪(trim)，让列表只保留指定区间内的元素，不在指定区间之内的元素都将被删除
 * 参数 key: string，start: int，stop: int
 * 返回值 array: 返回列表中剩余元素组成的数组。如果key值不是列表，返回FALSE
 */
    $redis->rPush('key1', 'A');
    $redis->rPush('key1', 'B');
    $redis->rPush('key1', 'C');
    $redis->lRange('key1', 0, -1); // array('A', 'B', 'C')
    $redis->lTrim('key1', 0, 1);
    $redis->lRange('key1', 0, -1); // array('A', 'B')

/**
 * rPop() 移除并获取列表最后一个元素
 * 参数 key: string
 * 返回值 string: 返回被移除的元素。失败(列表为空)返回FALSE
 */
    $redis->rPush('key1', 'A');
    $redis->rPush('key1', 'B');
    $redis->rPush('key1', 'C'); // key1 => ['A', 'B', 'C']
    $redis->rPop('key1'); // key1 => ['A', 'B']

/**
 * rPush() 将一个或多个值插入到列表的尾部(最右边)，如果列表不存在，一个空列表会被创建并执行rPush操作。 当列表存在但不是列表类型时，返回FALSE
 * 参数 key: string，value: string 要插入到列表的字符串
 * 返回值 int: 执行插入操作后，列表的长度。失败返回FALSE
 */
    $redis->delete('key1');
    $redis->rPush('key1', 'A'); // 返回 1
    $redis->rPush('key1', 'B'); // 返回 2
    $redis->rPush('key1', 'C'); // 返回 3
    // key1 => ['A', 'B', 'C']

/**
 * rPushX() 将一个值插入到已存在的列表尾部(最右边)。失败返回FALSE，如果列表不存在，操作无效。
 * 参数 key: string，value: string 要插入到列表的字符串
 * 返回值 int: 执行插入操作后，列表的长度。失败返回FALSE
 */
    $redis->delete('key1');
    $redis->rPushX('key1', 'A'); // 返回 0
    $redis->rPush('key1', 'A'); // 返回 1
    $redis->rPushX('key1', 'B'); // 返回 2
    $redis->rPushX('key1', 'C'); // 返回 3
    // key1 => ['A', 'B', 'C']

/**
 * lLen() 返回列表的长度。如果列表key不存在或为空列表，返回 0 。如果key不是列表类型，返回FALSE
 * 参数 Key: string
 * 返回值 int: 返回列表的长度。如果key不是列表，返回FALSE
 */
    $redis->rPush('key1', 'A');
    $redis->rPush('key1', 'B');
    $redis->rPush('key1', 'C'); // key1 => ['A', 'B', 'C']
    $redis->lSize('key1'); // 3
    $redis->rPop('key1');
    $redis->lSize('key1'); // 2