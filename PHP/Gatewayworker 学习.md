## Gatewayworker 学习

### 简介

GatewayWorker是基于Workerman开发的一个TCP长连接框架，实现了单发、群送、广播等长连接必用的接口。GatewayWorker框架实现了Gateway Worker进程模型，天然支持分布式多服务器部署，扩容缩容非常方便，能够应对海量并发连接。可以说GatewayWorker是基于Workerman实现的一个更完善的专门用于实现TCP长连接的项目框架。

### 与Laravel 等MVC框架集成，以websocket服务为例子

- laravel Console 自定义命令行启动文件，启动GatewayWorker ws 服务
- 自定义Events.php文件，做GatewayWorker业务回调逻辑，主要是几个事件onWorkerStart，
onConnect，
onWebSocketConnect，
onMesssge，
onClose，
onWorkerStop，
配合Lib\Gateway类提供的接口 实现 客户端之间通信，单发，群发，判断是否在线，主动推送，分组，等业务实现
- 长链接要设置心跳检测，客户端定时每X秒(推荐小于60秒)向服务端发送特定数据(任意数据都可)，服务端设定为X秒没有收到客户端心跳则认为客户端掉线，并关闭连接触发onClose回调。这样即通过心跳检测请求维持了连接(避免连接因长时间不活跃而被网关防火墙关闭)，也能让服务端比较及时的知道客户端是否异常掉线。
- 客户端之间消息做持久化，以redis为例子，发消息时，两人一个list，数组结构，把发送人接收人uid和内容，时间序列化存进去，如果对方为离线状态，则生成一个hash，结构为发送人接收人uid，并自增消息条数，当对方上线时，显示未读消息的条数和发送者，点开聊天框时，清空未读消息hash，并取出list消息内容
- GatewayWorker每个socket链接可以和自己业务uid绑定

### 参考文章
[gatewayworker手册](http://doc2.workerman.net/)
