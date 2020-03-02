<?php
// Redis 有序集合和集合一样也是string类型元素的集合,且不允许重复的成员。
// 不同的是每个元素都会关联一个double类型的分数。redis正是通过分数来为集合中的成员进行从小到大的排序。
// 有序集合的成员是唯一的,但分数(score)却可以重复。
// 集合是通过哈希表实现的，所以添加，删除，查找的复杂度都是O(1)。 集合中最大的成员数为 232 - 1 (4294967295, 每个集合可存储40多亿个成员)。

/**
 * zAdd() 向有序集合添加一个或多个成员，或者更新已存在成员的分数
 * 参数 key: string，score: double，value: string
 * 返回值 int: 成员添加成功返回 1，否则返回 0
 */
    $redis->zAdd('key', 1, 'val1');
    $redis->zAdd('key', 0, 'val0');
    $redis->zAdd('key', 5, 'val5');
    $redis->zRange('key', 0, -1); // array(val0, val1, val5)

/**
 * zSize() 计算集合中元素的数量
 * 参数 key: string
 * 返回值 int: 返回有序集的基数
 */
    $redis->zAdd('key', 0, 'val0');
    $redis->zAdd('key', 2, 'val2');
    $redis->zAdd('key', 10, 'val10');
    $redis->zSize('key'); // 3

/**
 * zCount() 计算有序集合中指定分数区间的成员数量
 * 参数 key: string，start: float，end: float
 * 返回值 int: 分数值在指定间的成员的数量
 */
    $redis->zAdd('key', 0, 'val0');
    $redis->zAdd('key', 2, 'val2');
    $redis->zAdd('key', 10, 'val10');
    $redis->zCount('key', 0, 3); // 2

/**
 * zIncrBy() 对有序集合中指定成员的分数加上增量
 * 参数 key: string，value: float 分数的增量，member: string
 * 返回值 float: 返回成员的新分数值
 */
    $redis->delete('key');
    $redis->zIncrBy('key', 2.5, 'member1'); // key 或 member1 不存在，member1 的分数被初始化为 0。现在 member1 的分数为 2.5
    $redis->zIncrBy('key', 1, 'member1'); // 3.5

/**
 * zinterstore() 计算给定的一个或多个有序集的交集，其中给定 key 的数量必须以 numkeys 参数指定，并将该交集(结果集)储存到新结果集
 * 参数 :
    * keyOutput: string
    * ZSetKeys: array
    * Weights: array 可选，权重，聚合操作之前，集合中所有元素的分数值先乘上权重
    * aggregateFunction: string 可选，SUM或MIN或MAX，定义如何计算结果集中某个成员的分数值
 * 返回值 int: 保存到目标结果集的的成员数量
 */
    $redis->delete('k1');
    $redis->delete('k2');
    $redis->delete('k3');

    $redis->delete('ko1');
    $redis->delete('ko2');
    $redis->delete('ko3');
    $redis->delete('ko4');

    $redis->zAdd('k1', 0, 'val0');
    $redis->zAdd('k1', 1, 'val1');
    $redis->zAdd('k1', 3, 'val3');

    $redis->zAdd('k2', 2, 'val1');
    $redis->zAdd('k2', 3, 'val3');

    $redis->zinterstore('ko1', ['k1', 'k2']); // 2, ko1 => array('val1', 'val3')
    $redis->zinterstore('ko2', ['k1', 'k2'], [1, 1]); // 2, ko2 => array('val1', 'val3')

    // 使用 Weights 参数
    $redis->zinterstore('ko3', ['k1', 'k2'], [1, 5], 'min'); // 2, ko3 => array('val1', 'val3')
    $redis->zinterstore('ko4', ['k1', 'k2'], [1, 5], 'max'); // 2, ko4 => array('val3', 'val1')

/**
 * zPop 可以从一个ZSET中移除并弹出得分最高或最低的成员。 有两个命令（“ ZPOPMIN”和“ ZPOPMAX”分别弹出最低和最高得分的元素。）
 * 参数 key: string，count: int 代表弹出几个元素，不写代表默认1个
 * 返回值 array:包含键成员且得分最高或最低的元素的数组；如果没有可用的元素，则为空数组。
 */
    //从集合zs1中弹出最低得分成员1个。
    $redis->zPopMin('zs1');

    //从集合zs1中弹出最高得分成员5个。
    $redis->zPopMax('zs1', 5);

/**
 * zRange() 通过索引区间返回有序集合成指定区间内的成员，下标参数start和stop都以0为底，0表示有序集第一个成员，以 1 表示有序集第二个成员，以此类推。以 -1 表示最后一个成员， -2 表示倒数第二个成员，以此类推
 * 参数key: string，start: int，end: int，withscores: bool 默认FALSE
 * 返回值 array: 指定区间内，带有分数值(可选)的有序集成员的列表
 */
    $redis->zAdd('key1', 0, 'val0');
    $redis->zAdd('key1', 2, 'val2');
    $redis->aAdd('key1', 10, 'val10');
    $redis->zRange('key1', 0, -1); // array('val0', 'val2', 'val10')
    // 带上得分值
    $redis->zRange('key1', 0, -1, true); // array('val0' => 0, 'val2' => 2, 'val10' => 10)

/**
 * zRangeByScore() 返回有序集合中指定分数区间的成员列表。有序集成员按分数值递增(从小到大，zRevRangeByScore()为从大到小)次序排列
 * 参数 key: string，start: string，end: string，
 * options: array 有两种可用options: withscores => TRUE和limit => array($offset, $count)
 * 返回值 array: 指定区间内，带有分数值(可选)的有序集成员的列表
 */
    $redis->zAdd('key', 0, 'val0');
    $redis->zAdd('key', 2, 'val2');
    $redis->zAdd('key', 10, 'val10');
    $redis->zRangeByScore('key', 0, 3); // array('val0', 'val2')
    $redis->zRangeByScore('key', 0, 3, ['withscores' => TRUE]); // array('val0' => 0, 'val2' => 2)
    $redis->zRangeByScore('key', 0, 3, ['limit' => [1, 1]]); // array('val2')
    $redis->zRangeByScore('key', 0, 3, ['withscores' => TRUE, 'limit' => [1, 2]]); // array('val2' => 2)

/**
 * zRangeByLex() 通过字典区间返回有序集合的成员，min和max参数必须以(、[开头，或者为-和+。
 * 必须使用三个或五个参数调用该方法，否则将返回FALSE
 * 参数 key: string，min: string，max: string
 * offset: int 可选，起始位置，limit: int 可选，返回元素的个数
 * 返回值 array: 指定区间内的元素列表
 */
    foreach (['a', 'b', 'c', 'd', 'e', 'f', 'g'] as $c)
        $redis->zAdd('key', 0, $c);
    
    $redis->zRangeByLex('key', '-', '[c'); // array('a', 'b', 'c')
    $redis->zRangeByLex('key', '-', '(c'); // array('a', 'b')
    $redis->zRangeByLex('key', '-', '[c', 1, 2); // array('b', 'c')

/**
 * zRange() 返回有序集中指定成员的排名，排名以 0 开始。其中有序集成员按分数值递增(从小到大，zRevRank() 有大到小)顺序排列
 * 参数 key: string，member: string
 * 返回值 int: 元素在集合中的排名
 */
    $redis->delete('z');
    $redis->zAdd('key', 1, 'one');
    $redis->zAdd('key', 2, 'two');
    $redis->zRank('key', 'one'); // 0
    $redis->zRank('key', 'two'); // 1
    $redis->zRevRank('key', 'one'); // 1
    $redis->zRevRank('key', 'two'); // 0

/**
 * zRem() 移除有序集合中的一个或多个成员
 * 参数 key: string，member: string
 * 返回值 int: 成功返回 1，失败返回 0
 */
    $redis->zAdd('key', 0, 'val0');
    $redis->zAdd('key', 2, 'val2');
    $redis->zAdd('key', 10, 'val10');
    $redis->zDelete('key', 'val2');
    $redis->zRange('key', 0, -1); // array('val0', 'val10')

/**
 * zRemRangeByRank() 移除有序集合中给定的排名区间的所有成员
 * 参数 key: string，start: int，end: int
 * 返回值 int: 被移除成员的数量
 */
    $redis->zAdd('key', 1, 'one');
    $redis->zAdd('key', 2, 'two');
    $redis->zAdd('key', 3, 'three');
    $redis->zRemRangeByRank('key', 0, 1); // 2
    $redis->zRange('key', 0, -1, ['withscores' => TRUE]); // array('three' => 3)

/**
 * zRemRangeByScore() 移除有序集合中给定的分数区间的所有成员
 * 参数 key: string，start: float/string，end: float/string
 * 返回值 int: 被移除成员的数量
 */
    $redis->zAdd('key', 0, 'val0');
    $redis->zAdd('key', 2, 'val2');
    $redis->zAdd('key', 10, 'val10');
    $redis->zRemRangeByScore('key', 0, 3); // 2

/**
 * zRevRange() 返回有序集中指定区间内的成员，通过索引，分数从高到底，下标参数start和stop都以0为底，0表示有序集第一个成员，以 1 表示有序集第二个成员，以此类推。以 -1 表示最后一个成员， -2 表示倒数第二个成员，以此类推
 * 参数 key: string，start: int，end: int，withscores: bool 默认FALSE
 * 返回值 array: 指定区间内，带有分数值(可选)的有序集成员的列表
 */
    $redis->zAdd('key', 0, 'val0');
    $redis->zAdd('key', 2, 'val2');
    $redis->zAdd('key', 10, 'val10');
    $redis->zRevRange('key', 0, -1); // array('val10', 'val2', 'val0')

    // 带分数值
    $redis->zRevRange('key', 0, -1, true); // array('val10' => 10, 'val2' => 2, 'val0' => 0)

/**
 * zScore() 返回有序集中，成员的分数值
 * 参数 key: string，member: string
 * 返回值 float
 */
    $redis->zAdd('key', 2.5, 'val2');
    $redis->zScore('key', 'val2'); // 2.5

/**
 * zunionstore() 计算给定的一个或多个有序集的并集，并存储在新的key中
 * 参数 keyOutput: string
    * ZSetKeys: array
    * Weights: array 权重，聚合操作之前，集合的所有元素分数值乘上权重
    * aggregateFunction: string SUM、MIN或MAX，定义如何计算结果集中某个成员的分数值
 * 返回值 int: 保存到结果集的成员数量
 */
    $redis->delete('k1');
    $redis->delete('k2');
    $redis->delete('k3');
    $redis->delete('ko1');
    $redis->delete('ko2');
    $redis->delete('ko3');

    $redis->zAdd('k1', 0, 'val0');
    $redis->zAdd('k1', 1, 'val1');

    $redis->zAdd('k2', 2, 'val2');
    $redis->zAdd('k2', 3, 'val3');

    $redis->zunionstore('ko1', ['k1', 'k2']); // 4, ko1 => array('val0', 'val1', 'val2', 'val3')

    // 使用 Weights 参数
    $redis->zunionstore('ko2', ['k1', 'k2'], [1, 1]); // 4, ko2 => array('val0', 'val1', 'val2', 'val3')
    $redis->zunionstore('ko3', ['k1', 'k2'], array(5, 1)); // 4, ko3 => array('val0', 'val2', 'val3', 'val1')

/**
 * zScan() 迭代有序集合中的元素（包括元素成员和元素分值）
 * 参数 key: string，iterator: int 迭代次数的引用，初始值为 0，pattern: string 可选，匹配模式
 * 返回值 array/boolean: 返回符合匹配模式的元素集合，迭代完成时返回FALSE
 */
    $it = NULL;
    $redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY);
    while ($arr_matches = $redis->zScan('zset', $it, '*pattern*')) {
        foreach ($arr_matches as $str_mem => $f_score) {
            echo "key: $str_mem, Score: $f_score\n";
        }
    }