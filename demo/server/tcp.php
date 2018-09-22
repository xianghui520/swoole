<?php


//创建Server对象，监听 127.0.0.1:9501端口
$serv = new swoole_server("103.40.18.29", 9501);

$serv->set([
    'worker_num' => 4,    //worker process num
    'max_request' => 50,

]);

/**
 *  $fd客户端链接唯一标识
 *  $reactor_id 线程id
 *
 */

//监听连接进入事件
$serv->on('connect', function ($serv, $fd,$from_id) {
    echo "Client_henry:{$from_id} - {$fd}-Connect.\n";
});

//监听数据接收事件
$serv->on('receive', function ($serv, $fd, $from_id, $data) {
    $serv->send($fd, "Server:{$from_id}-{$fd}".'-'.$data);//发送数据
});

//监听连接关闭事件
$serv->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});

//启动服务器
$serv->start();