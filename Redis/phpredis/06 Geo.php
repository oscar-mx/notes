<?php

class RedisGeo
{
    /** @var \Redis */
    protected $handler;

    /**
     * 配置参数
     * @var array
     */
    protected $options = [
        'host'       => '127.0.0.1',
        'port'       => 6379,
        'password'   => '',
        'select'     => 0,
        'timeout'    => 0,
        'expire'     => 0,
        'persistent' => false,
        'prefix'     => '',
        'tag_prefix' => 'tag:',
        'serialize'  => [],
    ];

    public function __construct(array $options = [])
    {
        if (!empty($options)) {
            $this->options = array_merge($this->options, $options);
        }

        if (extension_loaded('redis')) {
            $this->handler = new \Redis;

            if ($this->options['persistent']) {
                $this->handler->pconnect($this->options['host'], (int) $this->options['port'], (int) $this->options['timeout'], 'persistent_id_' . $this->options['select']);
            } else {
                $this->handler->connect($this->options['host'], (int) $this->options['port'], (int) $this->options['timeout']);
            }

            if ('' != $this->options['password']) {
                $this->handler->auth($this->options['password']);
            }
        } else {
            throw new \BadFunctionCallException('not support: redis');
        }

        if (0 != $this->options['select']) {
            $this->handler->select((int) $this->options['select']);
        }
    }

    public function example()
    {
        // 添加 经纬度信息 单个、多个
        $this->handler->geoAdd('citys', 116.404, 39.915, '北京');
        $this->handler->geoAdd('citys', 121.4648, 31.2894, '上海', 106.504, 29.590, '广州');

        // 获取经纬度hash
        dump($this->handler->geoHash('北京'));
        dump($this->handler->geoHash('上海', '广州'));

        // 获取经纬度
        dump($this->handler->geopos('北京'));
        dump($this->handler->geopos('上海', '广州'));

        // 获取两个位置的距离
//        'm' => Meters
//        'km' => Kilometers
//        'mi' => Miles
//        'ft' => Feet
        dump($this->handler->geoDist('citys', '北京', '上海'));
        dump($this->handler->geoDist('citys', '北京', '上海', 'km'));

        // 基于经纬度坐标的范围查询
        $options = [
            'WITHCOORD',//表示获取成员经纬度
            'WITHDIST',//表示获取成员距离
            'WITHHASH',//表示获取成员hash值
            'COUNT',//表示获取成员数量
            10,//表示获取成员数量
            'ASC',//表示获取成员距离 从近到远 二选一
            //'DESC',//表示获取成员距离 从远到近 二选一
        ];
        dump($this->handler->geoRadius('citys', 116.404, 39.915, 100, 'km', $options));
        dump($this->handler->geoRadius('citys', 116.404, 39.915, 100, 'km'));

        // 基于成员位置范围查询
        $options1 = [
            'WITHCOORD',//表示获取成员经纬度
            'WITHDIST',//表示获取成员距离
            'WITHHASH',//表示获取成员hash值
            'COUNT',//表示获取成员数量
            10,//表示获取成员数量
            'ASC',//表示获取成员距离 从近到远 二选一
            //'DESC',//表示获取成员距离 从远到近 二选一
        ];
        dump($this->handler->geoRadiusByMember('citys', '北京', 100, 'km', $options1));
    }
}
