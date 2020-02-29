<?php
    //连接本地的 Redis 服务
    $redis = new Redis();
    $result = $redis->connect('127.0.0.1', 6379);
    var_dump($result); //true为连接成功
    print_r('<br/>');

    //string字符串
    //set设置指定key的值，返回值布尔值；get获取key的值，成功返回key值，失败返回false
    $redis->set('name', 'xiaoming');
    // 将调用SETEX方法
    $redis->set('key', 'value', 10);
    // 设置key值，如果key不存在，设置10s过期 ex秒数
    $redis->set('key', 'value', array('nx', 'ex' => 10));
    // 设置key值，如果key存在，设置1000ms过期 px毫秒数
    $redis->set('key', 'value', array('xx', 'px' => 1000));
    $name = $redis->get('name');

    //setEx, pSetEx 为key赋值，并设置过期时间(setEx使用秒数，pSetEx使用毫秒)，返回值布尔值
    $redis->setEx('key', 3600, 'value'); // 设置key值，1h过期
    $redis->pSetEx('key', 100, 'value'); // 设置key值，100ms过期

    //setNx 在key不存在时设置key的值，返回值布尔值
    $redis->setNx('key', 'value');

    //delete 删除key，多个key传数组 redis4.0以后可以用unlink()方法和delete一样，返回值会删除key的个数
    $redis->set('key1', 'val1');
    $redis->set('key2' ,'val2');
    $redis->set('key3', 'val3');
    $redis->set('key4', 'val4');
    $redis->delete('key1' ,'key2'); // 返回 2
    $redis->delete(array('key3', 'key4')); // 返回 2

    //exists 检查key是否存在，返回值为检查的key个数
    $redis->set('key', 'value');
    echo $redis->exists('key');// 1
    echo $redis->exists('noneKey');// 0

    //incr incrBy key值自增1，第二个参数为key的增量，返回值为key自增后的值
    $redis->incr('key1'); // 若 key1 不存在，自增前默认为 0 ，然后自增 1
    $redis->incr('key1'); // 2
    $redis->incr('key1'); // 3
    $redis->incr('key1'); // 4
    // 二个参数为key的增量，将调用INCRBY
    $redis->incr('key1', 10); // 14
    $redis->incrBy('key1', 10); // 24

    //incrByFloat 将key所储存的值加上给定的浮点增量值
    $redis->incrByFloat('key1', 1.5); // 若 key1 不存在, 自增前默认为 0 ，然后自增 1.5
    $redis->incrByFloat('key1', 1.5); // 3 
    $redis->incrByFloat('key1', -1.5); // 1.5
    $redis->incrByFloat('key1', 2.5); // 4 

    //decr，decrBy为自减，用法和incr，incrBy同理

    //mGet 获取所有(一个或多个)给定key的值，如果有一个或多个key不存在，对应的key值为FALSE
    $redis->set('key1', 'value1');
    $redis->set('key2', 'value2');
    $redis->set('key3', 'value3');
    $redis->mGet(array('key1', 'key2', 'key3')); // array('value1', 'value2', 'value3');
    $redis->mGet(array('key0', 'key1', 'key5')); // array('FALSE', 'value1', 'FALSE');

    //getSet 将给定key的值设为value，并返回key的旧值
    $redis->set('name', 'oscar');
    $oldValue = $redis->getSet('name', 'oscarmx'); // 返回 'oscar', key 的值替换为 'oscarmx'
    $newValue = $redis->get('name'); // 返回 'oscarmx'

    // 从当前数据库中随机返回一个key
    $key = $redis->randomKey();
    $surprise = $redis->get($key);	// 随机返回，谁也不知道是啥...

    //move 将当前数据库的key移动到指定的数据库当中，返回值布尔值
    $redis->select(0);// 切换到数据库 0
    $redis->set('name', 'oscar');
    $redis->move('name', 1);// 移动 name 到数据库 1
    $redis->select(1);// 切换到数据库 1
    $redis->get('name');

    //rename修改key的名称，返回值布尔值
    $redis->set('name', 'oscar');
    $redis->rename('name', 'en_name');
    $redis->get('en_name'); // oscar
    $redis->get('name'); // FALSE

    //expire 为给定key设置过期时间，以秒计(pexpire为毫秒)，返回值布尔值
    $redis->set('x', '42');
    $redis->setTimeout('x', 3); // x 在 3s 后过期
    sleep(5);
    $redis->get('x'); // 返回 FALSE

    //expireAt 将key的过期时间设置为unix时间戳，返回值布尔值
    $redis->set('x', '42');
    $now = time(NULL);
    $redis->expireAt('x', $now + 3); // x 在 3s 后过期
    sleep(5);
    $redis->get('x'); // 返回 FALSE

    //keys 查找所有符合给定模式(pattern)的key
    $allKeys = $redis->keys('*'); // 匹配所有 key
    $keyWithUserPrefix = $redis->keys('user*');

    //scan 扫描所有key，返回keys数组，如果Redis中key数量为 0，返回FALSE

    // 不启用 Redis::SCAN_RETRY 
    $it = NULL;
    do {
        // 扫描 keys
        $arr_keys = $redis->scan($it);

        // 返回值可能为空，注意
        if ($arr_keys !== FALSE) {
            foreach($arr_keys as $str_key) {
                echo "Here is a key: $str_key\n";
            }
        }
    } while ($it > 0);
    echo "No more keys to scan!\n";

    // 启用 Redis::SCAN_RETRY 
    $redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY);
    $it = NULL;

    // 如果返回值为空，phpredis 会再次执行 SCAN，因此不需要检查结果是否为空
    while ($arr_keys = $redis->scan($it)) {
        foreach ($arr_keys as $str_key) {
            echo "Here is a key: $str_key\n";
        }
    }
    echo "No more keys to scan!\n";

    //object 获取key对象信息 encoding返回string，refcount返回int，如果为idletime，key不存在时返回FALSE
    //参数可以为：encoding返回特定key对应值的内部编码方式；  refcount返回特定key对应值的引用计数；  idletime返回特定key的空闲时间(既没有被读，也没有被写)
    $redis->object('encoding', 'l'); // ziplist
    $redis->object('refcount', 'l'); // 1
    $redis->object('idletime', '1'); // 400s，精度为10s

    //type 返回key所储存的值的类型
        // 根据key值的数据类型，此方法返回以下值：
        // string: Redis::REDIS_STRING
        // set: Redis::REDIS_SET
        // list: Redis::REDIS_LIST
        // zset: Redis::REDIS_ZSET
        // hash: Redis::REDIS_HASH
        // other: Redis::REDIS_NOT_FOUND
    $redis->type('key');

    //append 追加一个值到key，返回值为追加之后，key中字符串的长度
    $redis->set('key', 'value1');
    $redis->append('key', 'value2'); // 返回 12
    $redis->get('key'); // 'value1value'

    //getRange 返回key中字符串值的子字符串，字符串截取范围由start 和 end 两个偏移量决定(包括 start 和 end 在内)，返回值为截取到的字符串
    $redis->set('key', 'string value');
    $redis->getRange('key', 0, 5); // 'string'
    $redis->getRange('key', -5, -1); // 'value'

    //setRange 用指定字符串覆盖给定key值字符串，参数offset为开始位置，返回值为修改后的字符串长度
    $redis->set('key', 'Hello world');
    $redis->setRange('key', 6, 'redis'); // 返回 11
    $redis->get('key'); // 'Hello redis'

    /**
     * strLen() 返回key所储存的字符串值的长度
     * 参数 key: string
     * 返回值 int
     */
    $redis->set('key', 'value');
    $redis->strLen('key'); // 5

    /**
     * getBit() 对key所储存的字符串值，获取指定偏移量上的位(bit)
     * 参数 key: string ；offset: int
     * 返回值 int: 指定位上的值(0 或 1)
     */
    $redis->set('key', "\x7f"); // 0111 1111
    $redis->getBit('key', 0); // 0
    $redis->getBit('key', 1); // 1

    /**
     * setBit() 对key所储存的字符串值，设置或清除指定偏移量上的位(bit)
     * 参数 key: string ；offset: int ；value: int 1 或 0
     * 返回值 int: 0 或 1，设置之前的位值
     */
    $redis->set('key', '*'); // ord('*') = 42 = 0x2a = '0010 1010'
    $redis->setBit('key', 5, 1); // 返回 0
    $redis->setBit('key', 7, 1); // 返回 0
    $redis->get('key'); // chr(0x2f) = '/' = b('0010 1111')

    /**
     * sort() 对列表、集合或有序集中的元素进行排序
     * 参数 Key: string ；Options: array array(key => value, ...) - 可选，使用以下键值对:
        * 'by' => 'some_pattern_*',
        * 'limit' => array(0, 1),
        * 'get' => 'some_other_pattern_*' 或 patterns 数组
        * 'sort' => 'asc'/'desc',
        * 'alpha' => TRUE,
        * 'store' => 'external-key'
    * 返回值 array: key值数组，或存储的元素个数
    */
    $redis->delete('s');
    $redis->sAdd('s', 5);
    $redis->sAdd('s', 4);
    $redis->sAdd('s', 2);
    $redis->sAdd('s', 1);
    $redis->sAdd('s', 3);

    var_dump($redis->sort('s')); // 1, 2, 3, 4, 5
    var_dump($redis->sort('s', array('sort' => 'desc'))); // 5, 4, 3, 2, 1
    var_dump($redis->sort('s', array('sort' => 'desc', 'store' => 'out'))); // (int) 5

    /**
     * ttl(), pttl() 获取key的剩余的过期时间，秒数(ttl)，毫秒数(pptl)
     * 参数 Key: string
     * 返回值 int: key的过期时间。如果key没有过期时间，返回-1；key不存在，返回-2
     */
    $redis->ttl('key');

    /**
     * persist() 移除key的过期时间，key将持久保持
     * 参数 Key: string
     * 返回值 boolean: 成功移除过期时间，返回TRUE；key不存在，或没有过期时间，返回FALSE;
     */
    $redis->persist('key');

    /**
     * mSet() 同时设置一个或多个 key-value 对
     * 参数 Pairs: array array(key => value, ...)
     * 返回值 boolean: 成功返回TRUE，失败返回FALSE
     */
    $redis->mSet(array('key0' => 'value0', 'key1' => 'value1'));
    var_dump($redis->get('key0')); // string(6) "value0"
    var_dump($redis->get('key1')); // string(6) "value1"

    /**
     * dump() 序列化给定key，并返回被序列化的值
     * 参数 key string
     * 返回值 string/boolean: 返回序列化之后的值，如果key不存在，返回FALSE
     */
    $redis->set('foo', 'bar');
    $val = $redis->dump('foo');

    /**
     * restore() 用通过 dump 获得的序列化值创建一个key
     * 参数 key: string；ttl: integer key的存活时间，为 0 时不设置过期时间；value: string dump获得的序列化值
     */
    $redis->set('foo', 'bar');
    $val = $redis->dump('foo');
    $redis->restore('bar', 0, $val); // 'bar'的值不等于'foo'的值

    /**
     * migrate() 将key从一个Redis实例转移到另一个实例
     * 参数：
        * host:string 目标域名
        * port: int 要连接的TCP端口
        * key(s): string/array
        * destination-db: int 目标数据库
        * timeout: int 转移超时时间
        * copy: boolean 可选，是否复制
        * replace: boolean 是否替换
    */
    $redis->migrate('backup', 6379, 'foo', 0, 3600);
    $redis->migrate('backup', 6379, 'foo', 0, 3600, true, true); // 复制和替换
    $redis->migrate('backup', 6379, 'foo', 0, 3600, false, true); // 仅替换

    // 转移多个 key，要求 Redis >= 3.0.6
    $redis->migrate('backup', 6379, ['key1', 'key2', 'key3'], 0, 3600);