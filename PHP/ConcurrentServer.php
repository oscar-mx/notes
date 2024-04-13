<?php

class ConcurrentServer
{
    private $host;
    private $port;
    private $maxProcesses;

    public function __construct($host, $port, $maxProcesses = 10)
    {
        $this->host = $host;
        $this->port = $port;
        $this->maxProcesses = $maxProcesses;
    }

    // 启动并发服务器
    public function start()
    {
        // 创建 Socket 服务器
        $socket = stream_socket_server("tcp://{$this->host}:{$this->port}", $errno, $errstr);
        if (!$socket) {
            die("Error: $errstr ($errno)\n");
        }

        echo "Server started at {$this->host}:{$this->port}\n";

        // 处理客户端连接请求
        $this->handleClients($socket);
    }

    // 处理客户端连接请求
    private function handleClients($socket)
    {
        $processes = [];

        while (true) {
            // 接受客户端连接请求
            $clientSocket = stream_socket_accept($socket);

            // 创建子进程处理客户端连接
            $pid = pcntl_fork();
            if ($pid == -1) {
                // fork 失败
                die("Error: Fork failed\n");
            } elseif ($pid) {
                // 父进程
                $processes[] = $pid;
                // 关闭父进程中的客户端套接字
                fclose($clientSocket);
                // 检查子进程数量是否达到最大限制，如果达到则等待一个子进程退出
                $this->waitChildProcess($processes);
            } else {
                // 子进程
                // 关闭服务器监听套接字
                fclose($socket);
                // 处理客户端请求
                $this->handleClient($clientSocket);
                // 关闭子进程中的客户端套接字
                fclose($clientSocket);
                // 子进程处理完毕后退出
                exit(0);
            }
        }

        // 关闭服务器监听套接字
        fclose($socket);
    }

    // 处理单个客户端连接
    private function handleClient($clientSocket)
    {
        // 读取客户端发送的数据
        $data = fread($clientSocket, 1024);
        // 处理数据（这里简单地将收到的数据原样返回给客户端）
        fwrite($clientSocket, "Received: $data");
    }

    // 等待一个子进程退出
    private function waitChildProcess(&$processes)
    {
        // 如果当前子进程数量达到最大限制，等待一个子进程退出
        while (count($processes) >= $this->maxProcesses) {
            $pid = pcntl_waitpid(-1, $status);
            if ($pid > 0) {
                $key = array_search($pid, $processes);
                unset($processes[$key]);
            }
        }
    }
}


