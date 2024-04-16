<?php


use Revolt\EventLoop;

class EventLoopEg
{
    public function loop()
    {
        // 获取挂起对象
        $suspension = EventLoop::getSuspension();

        // 创建重复执行任务
        $repeatId = EventLoop::repeat(1, function (): void {
            print '++ Executing callback created by EventLoop::repeat()' . PHP_EOL;
        });

        // 创建延时任务
        EventLoop::delay(5, function () use ($suspension, $repeatId): void {
            print '++ Executing callback created by EventLoop::delay()' . PHP_EOL;

            EventLoop::cancel($repeatId);//取消回调
            $suspension->resume(null);//恢复挂起

            print 'Suspension::resume() is async!' . PHP_EOL;
        });

        print 'Suspending to event loop...' . PHP_EOL;

        $suspension->suspend();// 挂起执行

        print '++ Script end' . PHP_EOL;

//        ++ Suspending to event loop...
//        ++ Executing callback created by EventLoop::repeat()
//        ++ Executing callback created by EventLoop::repeat()
//        ++ Executing callback created by EventLoop::repeat()
//        ++ Executing callback created by EventLoop::repeat()
//        ++ Executing callback created by EventLoop::delay()
//        ++ Suspension::resume() is async!
//        ++ Script end
    }

    public function nio()
    {
        if (\stream_set_blocking(STDIN, false) !== true) {
            \fwrite(STDERR, "设置STDIN非阻塞失败" . PHP_EOL);
            exit(1);
        }

        print "写点什么 然后点击 Enter" . PHP_EOL;

        $suspension = EventLoop::getSuspension();

        $readableId = EventLoop::onReadable(STDIN, function ($id, $stream) use ($suspension): void {
            EventLoop::cancel($id);

            $chunk = \fread($stream, 8192);

            print "Read " . \strlen($chunk) . " bytes" . PHP_EOL;

            $suspension->resume(null);
        });

        $timeoutId = EventLoop::delay(30, function () use ($readableId, $suspension) {
            EventLoop::cancel($readableId);

            print "超时 请重新输入" . PHP_EOL;

            $suspension->resume(null);
        });

        $suspension->suspend();

        EventLoop::cancel($readableId);
        EventLoop::cancel($timeoutId);
    }
}
