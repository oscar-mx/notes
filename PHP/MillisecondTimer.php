<?php

namespace app\extend;

use SplPriorityQueue;

class MillisecondTimer
{
    // 用于存储定时器的队列
    private $queue;
    private $sockets;

    public function __construct() {
        $this->sockets = stream_socket_pair(DIRECTORY_SEPARATOR === '/' ? STREAM_PF_UNIX : STREAM_PF_INET, STREAM_SOCK_STREAM, STREAM_IPPROTO_IP);
        // 初始化优先队列
        $this->queue = new SplPriorityQueue();
        // 设置队列数据结构为堆
        $this->queue->setExtractFlags(SplPriorityQueue::EXTR_BOTH);
    }

    // 添加一个定时任务
    public function addTask(callable $task, int $milliseconds) {
        // 计算到期的时间戳
        $expiration = microtime(true) + ($milliseconds / 1000);
        // 将任务添加到队列中
        $this->queue->insert($task, -$expiration);
    }

    // 运行定时器
    public function run() {
        while (!$this->queue->isEmpty()) {
            // 获取当前时间戳
            $currentTime = microtime(true);

            // 获取距离下一个任务执行时间的等待时间
            $nextTask = $this->queue->top();
            $expiration = -$nextTask['priority'];
            $timeout = max(0, ($expiration - $currentTime) * 1000000);

            // 使用 stream_select 等待直到下一个任务需要执行
            $read = [$this->sockets[0]];
            $write = [];
            $except = [];
            stream_select($read, $write, $except, 0, $timeout);

            // 获取并执行到期的任务
            while (!$this->queue->isEmpty()) {
                $nextTask = $this->queue->top();
                $expiration = -$nextTask['priority'];

                // 如果任务还未到期，则退出循环
                if ($expiration > $currentTime) {
                    break;
                }

                // 执行任务
                $task = $this->queue->extract();
                $task['data']();
            }
        }
    }
}
//// 创建定时器实例
//$timer = new MillisecondTimer();
//
//// 添加定时任务
//$timer->addTask(function() {
//    echo "Task 3 executed\n";
//}, 3000); // 执行时间为 3000 毫秒后
//
//// 运行定时器
//$timer->run();
