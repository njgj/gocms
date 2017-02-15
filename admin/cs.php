<?php 
error_reporting(E_ALL & ~E_NOTICE);
//error_reporting(0);
$id =(int)$_GET['id'];
//$id=intval($_POST['id']);
$str=trim($_GET['str']);

$f=(float)($_GET['f']);
echo $str;
echo $id;
echo $f;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
</body>
</html>