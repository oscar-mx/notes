<?php

use SplDoublyLinkedList;

class SimpleMQ extends SplDoublyLinkedList
{
    /**
     * 队列存储
     * @var array
     */
    private static $queues = [];

    /**
     * 队列管理
     * @param $key
     * @return mixed|SplDoublyLinkedList
     */
    private static function manageKey($key)
    {
        if (!isset(self::$queues[$key])) {
            self::$queues[$key] = new SplDoublyLinkedList();
        }
        return self::$queues[$key];
    }

    /**
     * 插入列表头部
     * @param $key
     * @param $value
     * @return int
     */
    public static function lpush($key, $value)
    {
        $queue = self::manageKey($key);
        $queue->unshift($value); // 将值插入到队列的头部
        return $queue->count();
    }

    /**
     * 插入列表尾部
     * @param $key
     * @param $value
     * @return int
     */
    public static function rpush($key, $value)
    {
        $queue = self::manageKey($key);
        $queue->push($value); // 将值插入到队列的尾部
        return $queue->count();
    }

    /**
     * 移除列表的最后一个元素
     * @param $key
     * @return mixed|null
     */
    public static function rpop($key)
    {
        $queue = self::manageKey($key);
        if ($queue->isEmpty()) {
            unset(self::$queues[$key]); // 队列为空时删除键
            return null;
        }
        return $queue->pop(); // 从队列的尾部移除并返回值
    }

    /**
     * 移除列表第一个元素
     * @param $key
     * @return mixed|null
     */
    public static function lpop($key)
    {
        $queue = self::manageKey($key);
        if ($queue->isEmpty()) {
            unset(self::$queues[$key]); // 队列为空时删除键
            return null;
        }
        return $queue->shift(); // 从队列的头部移除并返回值
    }

    /**
     * 获取队列长度
     * @param $key
     * @return int
     */
    public static function llen($key)
    {
        $queue = self::manageKey($key);
        return $queue->count();
    }

    /**
     * 获取队列指定索引的值
     * @param $key
     * @param $index
     * @return null
     */
    public static function lindex($key, $index)
    {
        $queue = self::manageKey($key);
        if ($index < 0) {
            $index = $queue->count() + $index;
        }
        if ($index < 0 || $index >= $queue->count()) {
            return null;
        }
        return $queue->offsetGet($index);
    }

    /**
     * 获取队列指定范围内的元素
     * @param $key
     * @param $start
     * @param $end
     * @return array|null
     */
    public static function lrange($key, $start, $end)
    {
        if(!is_int($start) || !is_int($end)){
            return null;
        }
        $queue = self::manageKey($key);
        if($end == -1){
            $end = null;
        }
        return array_slice(iterator_to_array($queue), $start, $end);
    }

    public static function lrem($key, $count, $value)
    {
        $list = self::manageKey($key);
        $removedCount = 0;
        $direction = $count >= 0 ? 'top' : 'bottom';

        while ($count != 0 && ($current = $list->{$direction}()) !== false) {
            if ($current === $value) {
                $list->offsetUnset($list->key());
                $removedCount++;
                $count += $direction == 'top' ? -1 : 1;
            }
        }
        return $removedCount;
    }
}



