<?php
$client = new swoole_client(SWOOLE_SOCK_TCP);

//连接到服务器
if (!$client->connect('103.40.18.29', 9501))
{
    die("connect failed.");
}

//php cli 常量
fwrite(STDOUT,"请输入消息:");
$msg=trim(fgets(STDIN));

//数据发送给tcp服务
$client->send($msg);


//接受来自server的数据
$result=$client->recv();

echo $result;

//关闭连接
$client->close();