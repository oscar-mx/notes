<?php
/**
 * 简略版 单个客户端 php tcp 服务
 */

//创建一个套接字
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if (!$socket)
    die('server端 创建 socket服务 失败：' . socket_strerror(socket_last_error()) . PHP_EOL);

//绑定地址到套接字
$res = socket_bind($socket, '0.0.0.0', 1234);
if (!$res)
    die('server端 绑定 socket地址 失败：' . socket_strerror(socket_last_error()) . PHP_EOL);

//监听套接字的链接
$res = socket_listen($socket,1);
if (!$res)
    die('server端 监听 socket链接 失败：' . socket_strerror(socket_last_error()) . PHP_EOL);

echo '创建 socket 服务成功...等待客户端链接...' . PHP_EOL;

while (1) {
    //阻塞等待客户端链接
    $new_client = socket_accept($socket);
    if(!$new_client){
        echo '客户端 链接socket 失败：' . socket_strerror(socket_last_error()) . PHP_EOL;
        break;
    }
    echo '客户端 链接socket 成功' . PHP_EOL;

    recv($new_client);
}

//读取客户端的消息,并回应
function recv($new_client)
{
//循环读取消息
    $recv = '';
//实际接收到的消息
    while (1){
        $buffer = socket_read($new_client, 100);//每次读取100byte
        if ($buffer === false || $buffer === ''){
            echo "客户端关闭" . PHP_EOL;
            socket_close($new_client);//关闭本次连接
            break;
        }
        //解析单次消息，协议：换行符
        $pos = strpos($buffer, PHP_EOL);
        if ($pos === false){
            //消息未读取完毕，继续读取
            $recv .= $buffer;
        } else {
            //消息读取完毕
            $recv .= trim(substr($buffer, 0, $pos + 1));//去除换行符及空格
            //客户端主动关闭
            if ($recv == 'quit'){
                echo "客户端关闭" . PHP_EOL;
                socket_close($new_client);//关闭本次连接
                break;
            }
            echo "收到客户端消息:" . $recv  . PHP_EOL;
            socket_write($new_client, $recv  . PHP_EOL);//发送消息
            $recv = '';//清空消息，准备下一次接收
        }
    }
}

//关闭socket链接
socket_close($socket);

