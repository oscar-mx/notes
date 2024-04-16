<?php

use Revolt\EventLoop;

class TimerEg
{
    // 设置一个间隔时钟定时器 定期执行  $sec 秒 $callback 回调函数 $args 参数 需要手动释放 EventLoop::cancel($callbackId);
    public function tick($sec, $callback, $args = [])
    {
        $callbackId = EventLoop::repeat($sec, function () use ($callback, $args) {
            call_user_func_array($callback, $args);
        });
        EventLoop::run();
        return $callbackId;
    }

    // 设置一个延迟定时器 $sec 秒 $callback 回调函数 $args 参数
    public function after($sec, $callback, $args = [])
    {
        EventLoop::delay($sec, function () use ($callback, $args) {
            call_user_func_array($callback, $args);
        });
        EventLoop::run();
    }
}
