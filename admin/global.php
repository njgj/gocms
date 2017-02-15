<?php
set_time_limit(0);
session_start();
error_reporting(E_ALL & ~E_NOTICE);
define('ROOT',dirname(__FILE__));
include_once (ROOT.'/../configs/config.php');
include_once (ROOT.'/../include/mysql.class.php');
include_once (ROOT.'/../include/common.func.php');
include_once (ROOT.'/common/action.class.php');

//初始化数据库类
$db=new db();
$db->connect($mydbhost, $mydbuser, $mydbpw, $mydbname); //数据库操作类.

//设置默认时区
date_default_timezone_set('PRC');
//初始化数据库类
$db=new action();
//用户验证
$db->Get_user_check();
?>
