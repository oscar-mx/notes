# 目的
通过了解 binlog 日志的相关配置，简单掌握通过 binlog 对数据库进行数据恢复操作；

# mysql 日志文件
任何成熟软件都会有一套成熟的日志系统，当软件出现问题时，这些日志就是查询问题来源的宝库。同样，mysql 也不例外，也会有一系列日志记录 mysql 的运行状态。

mysql 主要有以下几种日志：

- 错误日志：记录 mysql 运行过程中的错误信息
- 一般查询日志：记录 mysql 正在运行的语句，包括查询、修改、更新等的每条 sql
- 慢查询日志：记录查询比较耗时的 SQL 语句
- binlog 日志：记录数据修改记录，包括创建表、数据更新等
这些日志均需要在 my.cnf 文件进行配置，如果不知道 mysql 的配置文件路径，可以使用 mysql 命令进行查找，

> mysql --verbose --help|grep -A 1 'Default options’ #该命令会罗列出my.cnf顺序查找的路径。

# binlog 日志
binlog 就是 binary log，二进制日志文件，记录所有数据库更新语句，包括表更新和记录更新，即数据操纵语言 (DML)，binlog 主要用于数据恢复和配置主从复制等；

- 数据恢复：当数据库误删或者发生不可描述的事情时，可以通过 binlog 恢复到某个时间点的数据。
- 主从复制：当有数据库更新之后，主库通过 binlog 记录并通知从库进行更新，从而保证主从数据库数据一致；
mysql 按照功能分为服务层模块和存储引擎层模块，服务层负责客户端连接、SQL 语句处理优化等操作，存储引擎层负责数据的存储和查询；binlog 属于服务层模块的日志，即引擎无关性，所有数据引擎的数据更改都会记录 binlog 日志。当数据库发生崩溃时，如果使用 InnoDB 引擎，binlog 日志还可以检验 InnoDB 的 redo 日志的 commit 情况。

# binlog 日志开启
# 日志开启方式：
1、添加配置
```
log_bin=ON
log_bin_basename=/path/bin-log
log_bin_index=/path/bin-log.index
```
2、仅仅设置 log-bin 参数
```
log-bin=/path/bin-log
```
当开启 binlog 日志之后，mysql 会创建一个 log_bin_index 指定的 .index 文件和多个二进制日志文件，index 中按顺序记录了 mysql 使用的所有 binlog 文件。binlog 日志则会以指定的名称 (或默认值) 加自增的数字作为后缀，ex：bin-log.000001，当发生下述三种情况时，binlog 日志便会进行重建:

```
文件大小达到 max_binlog_size 参数的值
执行 flush logs 命令
重启 mysql 服务
```

# binlog 日志格式
通过参数 binlog_format 参数的值，可以设置 binlog 的格式，可选值有 statement、row、mixed

- statement 格式：记录数据库执行的原始 SQL 语句
- row 格式：记录具体的行的修改，这个为目前默认值
- mixed 格式：因为上边两种格式各有优缺点，所以就出现了 mixed 格式
# binlog 日志查看工具：mysqlbinlog
因为 binlog 是二进制文件，不能像其他文件一样，直接打开查看。但 mysql 提供了 binlog 查看工具 mysqlbinlog，可以解析二进制文件。当然不同格式的日志解析结果是不一样的；

1. statement 格式日志，执行 mysqlbinlog /path/bin-log.000001，可以直接看到原始执行的 SQL 语句

2. row 格式日志，则可读性没有那么好，但仍可通过参数使文档更加可读 mysqlbinlog -v /path/bin-log.000001

mysqlbinlog 两对非常重要的参数

1. --start-datetime --stop-datetime 解析某一个时间段内的 binlog；
2. --start-position --stop-position 解析在两个 position 之间的 binlog；

# 使用 binlog 恢复数据：

使用 binlog 恢复数据，本质上就是通过 binlog 找到所有 DML 操作，去掉错误的 SQL 语句，然后重走一遍长征路，就可以将数据恢复；

# 线下实操：
1. 创建数据表并插入初始值

```sql
CREATE TABLE `users` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(255) DEFAULT NULL,
          `age` int(8) DEFAULT NULL,
          PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 INSERT INTO `users` (`id`, `name`, `age`)
    VALUES
        (null, '姓名一', 5);
```
2. 找到上一次全量备份的数据库和 binlog 的 position (ps：当然也可以通过时间进行恢复)。此处以目前状态作为备份的初始值，
```sql
mysqldump -uroot -p T > /path/xxx.sql;   # 备份数据库
show master status;   # 查看当前的position位置，此时值为154
```
3. 插入多条记录
```sql
INSERT INTO `users` (`id`, `name`, `age`)
VALUES
 (null, '姓名二', 13),
 (null, '姓名三', 14),
 (null, '姓名四', 15),
 (null, '姓名五', 16),
 (null, '姓名六', 17);
```

4. 进行误操作，并且在误操作之后又插入几条数据
```sql
update users set age = 5；
INSERT INTO `users` (`id`, `name`, `age`)
VALUES
(null, '姓名七', 16),
(null, '姓名八', 18);
```

5. 发现误操作之后，进行数据恢复，首先停止 mysql 对外的服务，利用备份数据恢复到上次数据；

6. 通过 mysqlbinlog 命令对二进制文件进行分析，分析发现
```
误操作发生在position为706位置，且上次正常操作的结束位置在513
在1152到结尾位置有正常执行的SQL执行
```
7. 通过 mysqlbinlog 命令从 binlog 日志中导出可执行的 SQL 文件，并将数据导入到 mysql
```
mysqlbinlog --start-position=154  --stop-position=513  bin-log.000001 > /path/bak.sql;
mysql -uroot -p < /path/bak.sql;
```
8. 跳过错误的更新语句，再通过步骤 7 的逻辑把后续正常语句重新跑一遍，完成数据恢复工作

# 小结
无论什么时间，数据库发生崩溃都会令人愁眉紧锁，心烦意乱。binlog 可以说是在各种情况下，数据库崩溃、数据丢失之后的一粒后悔药，本文通过线下环境，简单的对数据库进行了一次数据恢复实验，如有不对，还请指教

# 参考文章

http://www.ywnds.com/?p=12839

https://zhuanlan.zhihu.com/p/33504555

# Thanks

[@lufeijun1234](https://learnku.com/blog/no)

https://learnku.com/articles/20628




