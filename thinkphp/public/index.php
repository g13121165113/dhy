<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
$origin = empty($_SERVER['HTTP_ORIGIN'])?'*':$_SERVER['HTTP_ORIGIN'];
header("Access-Control-Allow-Origin: $origin");
header("Access-Control-Allow-Credentials: true");
header("Content-Type:text/html;charset-utf-8");
// header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header('Access-Control-Max-Age: 1728000');
header("Access-Control-Allow-Headers: Origin, No-Cache,Token, X-Requested-With, If-Modified-Since, Pragma, Last-Modified, Cache-Control, Expires, Content-Type, X-E4M-With");
// [ 应用入口文件 ]
//$build = include '../build.php';
// 运行自动生成
//\think\Build::run($build);
// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
$build = include '../build.php';
// 运行自动生成
\think\Build::run($build);
