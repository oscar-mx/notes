<?php
    //连接本地的 Redis 服务
    $redis = new Redis();
    $result = $redis->connect('127.0.0.1', 6379);
    var_dump($result); //true为连接成功
    print_r('<br/>');

    //string字符串
    //set设置指定key的值，返回值布尔值；get获取key的值，成功返回key值，失败返回false
    $redis->set('name', 'xiaoming');
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
