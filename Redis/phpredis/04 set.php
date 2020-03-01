<?php
// Redis 的 Set 是 String 类型的无序集合。集合成员是唯一的，这就意味着集合中不能出现重复的数据。
// Redis 中集合是通过哈希表实现的，所以添加，删除，查找的复杂度都是 O(1)。
// 集合中最大的成员数为 232 - 1 (4294967295, 每个集合可存储40多亿个成员)。

/**
 * sAdd() 将一个或多个成员元素加入到集合中。如果元素已存在于集合中，返回FALSE
 * 参数 key: string，value: string
 * 返回值 int: 返回被添加到集合中的新元素的数量
 */
    $redis->sAdd('key1', 'member1'); // 1, key1 => {'member'}
    $redis->sAdd('key1', 'member2', 'member3'); // 2, key1 => {'member1', 'member2', 'member3'}
    $redis->sAdd('key1', 'member2'); // 0, key1 => {'member1', 'member2', 'member3'}

/**
 * sCard() 返回集合中元素的数量
 * 参数 key: string
 * 返回值 int: 返回集合中元素的数量。 当集合key不存在时，返回 0
 */
   $redis->sAdd('key1', 'member1');
   $redis->sAdd('key1', 'member2');
   $redis->sAdd('key1', 'member3'); // key1 => {'member1', 'member2', 'member3'}
   $redis->sCard('key1'); // 3
   $redis->sCard('keyX'); //0

/**
 * sDiff() 返回给定集合之间的差集
 * 参数 Keys: string key, key2, ..., keyN 指向集合的任意数量的key
 * 返回值 array: 第一个集合与其他所有集合差集元素组成的数组
 */
   $redis->delete('s0', 's1', 's2');

   $redis->sAdd('s0', '1');
   $redis->sAdd('s0', '2');
   $redis->sAdd('s0', '3');
   $redis->sAdd('s0', '4');

   $redis->sAdd('s1', '1');
   $redis->sAdd('s2', '3');

   var_dump($redis->sDiff('s0', 's1', 's2'));
   /*
   返回所有存在于 s0，但既不存在于 s1 也不存在于 s2 中的元素
   array(2) {
   [0]=>
   string(1) "4"
   [1]=>
   string(1) "2"
   }
   */

/**
 * sDiffStore() 将给定集合之间的差集存储在指定的集合中
 * 参数 dstKey: string 用于存储差集的key，keys: string key1, key2, ..., keyN 指向集合的任意数量的key
 * 返回值 int: 返回差集中的元素数量。如果某个key不存在，返回FALSE
 */
   $redis->delete('s0', 's1', 's2');

   $redis->sAdd('s0', '1');
   $redis->sAdd('s0', '2');
   $redis->sAdd('s0', '3');
   $redis->sAdd('s0', '4');

   $redis->sAdd('s1', '1');
   $redis->sAdd('s2', '3');

   var_dump($redis->sDiffStore('dst', 's0', 's1', 's2'));
   var_dump($redis->sMembers('dst'));
   /*
   返回所有存在于 s0，但既不存在于 s1 也不存在于 s2 中的元素
   int(2)
   array(2) {
   [0]=>
   string(1) "4"
   [1]=>
   string(1) "2"
   }
   */

/**
 * sInter() 返回给定所有给定集合的交集,当给定集合当中有一个空集时，结果也为空集。如果某个key不存在，返回FALSE
 * 参数 keys: string key1, key2, ..., keyN: string，指向集合的任意数量的key
 * 返回值 array: 返回交集成员组成的数组。如果交集为空，返回空数组
 */
   $redis->sAdd('key1', 'val1');
   $redis->sAdd('key1', 'val2');
   $redis->sAdd('key1', 'val3');
   $redis->sAdd('key1', 'val4');

   $redis->sAdd('key2', 'val3');
   $redis->sAdd('key2', 'val4');

   $redis->sAdd('key3', 'val3');
   $redis->sAdd('key3', 'val4');

   var_dump($redis->sInter('key1', 'key2', 'key3'));
   /*
   输出
   array(2) {
   [0]=>
   string(4) "val4"
   [1]=>
   string(4) "val3"
   }
   */

/**
 * sInterStore() 将给定集合之间的交集存储在指定的集合中
 * 参数dstKey: string 用于存储交集的key，keys: string key, key2, ..., keyN 指向集合的任意数量的key
 * 返回值 int: 返回存储交集的集合的元素数量。如果某个key不存在，返回FALSE
 */
   $redis->sAdd('key1', 'val1');
   $redis->sAdd('key1', 'val2');
   $redis->sAdd('key1', 'val3');
   $redis->sAdd('key1', 'val4');

   $redis->sAdd('key2', 'val3');
   $redis->sAdd('key2', 'val4');

   $redis->sAdd('key3', 'val3');
   $redis->sAdd('key3', 'val4');

   var_dump($redis->sInterStore('output', 'key1', 'key2', 'key3'));
   var_dump($redis->sMembers('output'));
   /*
   输出
   int(2)

   array(2) {
   [0]=>
   string(4) "val4"
   [1]=>
   string(4) "val3"
   }
   */

/**
 * sIsMember() 判断成员元素是否是集合的成员
 * 参数 key: string，value: string
 * 返回值 boolean: 如果元素是集合的成员，返回TRUE。否则返回FALSE
 */
   $redis->sAdd('key1', 'member1');
   $redis->sAdd('key1', 'member2');
   $redis->sAdd('key1', 'member3'); // key1 => {'member1', 'member2', 'member3'}

   $redis->sIsMember('key1', 'member1'); // TRUE
   $redis->sIsMember('key1', 'memberX'); // FALSE

/**
 * sMembers() 返回集合中的所有的成员
 * 参数 Key: string
 * 返回值 array: 集合中的所有成员组成的数组
 */
   $redis->delete('s');
   $redis->sAdd('s', 'a');
   $redis->sAdd('s', 'b');
   $redis->sAdd('s', 'a');
   $redis->sAdd('s', 'c');
   var_dump($redis->sMembers('s'));
   /*
   输出
   顺序随机，对应于Redis集合内部的排序
   array(3) {
   [0]=>
   string(1) "c"
   [1]=>
   string(1) "a"
   [2]=>
   string(1) "b"
   }
   */

/**
 * sMove() 将指定元素从当前集合移动到目标集合
 * 参数srcKey: string，dstKey: string，member: string
 * 返回值 boolean: 操作成功返回TRUE。如果当前key或目标key不存在，或元素不存在于当前key中，返回FALSE
 */
   $redis->sAdd('key1', 'member11');
   $redis->sAdd('key1', 'member12');
   $redis->sAdd('key1', 'member13'); // key1 => {'member11', 'member12', 'member13'}
   $redis->sAdd('key2', 'member21');
   $redis->sAdd('key2', 'member22'); // key2 => {'member21', 'member22'}
   $redis->sMove('key1', 'key2', 'member13');
   /*
   key1 => {'member11', 'member12'}
   key2 => {'member21', 'member22', 'member13'}
   */

/**
 * sScan() 迭代集合中的元素
 * 参数 Key: string 待迭代的key，iterator: int (引用) 迭代次数，pattern: string 可选，匹配模式，count: int 每次迭代返回的元素数量
 * 返回值 array/boolean: 返回元素数组或者FALSE
 */
   $it = NULL;
   $redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY); // 迭代完成前，不要返回空值
   while ($arr_mems = $redis->sScan('set', $it, '*pattern*')) {
      foreach ($arr_mems as $str_mem) {
         echo "Member: $str_mem\n";
      }
   }

   $it = NULL;
   $redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY); // 每次迭代都返回结果，无论结果是否为空
   while ($arr_mems = $redis->sScan('set', $it, '*pattern*') !== FALSE) {
      if (count($arr_mems) > 0) {
         foreach ($arr_mems as $str_mem) {
               echo "Member found: $str_mem\n";
         }
      } else {
         echo "No members in this iteration, iterator value: $it\n";
      }
   }