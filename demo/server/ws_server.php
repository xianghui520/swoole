<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 18/10/20
 * Time: 下午1:03
 */


//创建websocket服务器对象，监听0.0.0.0:9502端口
$ws = new swoole_websocket_server("0.0.0.0", 8812);

//监听WebSocket连接打开事件
$ws->on('open', function ($ws, $request) {
    echo "已经握手成功";
    var_dump($request->fd, $request->get, $request->server);
    $ws->push($request->fd, "hello, welcome\n");
});



//监听WebSocket消息事件
    $ws->on('message', function ($ws, $frame) {

        $ws->push($frame->fd, "server:".date("Y-m-d H:i:s",time()));
    });

//监听WebSocket连接关闭事件
$ws->on('close', function ($ws, $fd) {
    echo "client-{$fd} is closed\n";
});

$ws->start();