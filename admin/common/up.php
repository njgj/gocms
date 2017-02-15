<?php
header('content-type:text/html;charset=utf-8');
date_default_timezone_set('PRC');  
error_reporting(E_ALL & ~E_NOTICE);

$path=$_GET['path'].'/';
$type=$_GET['type'];

switch (strtolower($type)){
case '':
  $type='jpg|gif|bmp|png';
  break;  
case 'file':
  $type='doc|xls|ppt|txt|rar';
  break;
case 'media':
  $type='wma|rm|avi|swf';
  break;
default:
  $type='jpg|gif|bmp|png';
}

/**
 * 上传文件函数
 * 参数：表单属性名，文件保存路径，文件最大尺寸（KB），允许的类型。
 */
function upfile ($file,$path,$maxsize=1000,$type="jpg|gif|bmp|png") {
  if(!is_array($_FILES[$file]))return false;
  $filename=$_FILES[$file]['name'];  //文件名称不带路径
  $tmpname=$_FILES[$file]['tmp_name']; //临时文件名称带路径，去除转义
  $filesize=abs($_FILES[$file]['size']); //文件大小
  $fileerror=$_FILES[$file]['error'];  //文件上传错误信息
  $filetype=strtolower(end(explode('.',$filename)));  //获取文件后缀名不带.
  
  if(!is_dir($path))return "文件保存路径 {$path} 不存在";
  if(!is_writable($path))return "权限不足，无法写入文件"; 
  if($filesize<1)return "请选择上传文件";
  if($filesize>$maxsize*1024)return "请不要上传超过 {$maxsize}K 的文件";
  if(!in_array($filetype,explode('|',$type)))return "你能上传的文件类型为 $type";
  if($fileerror)return "未知错误，上传失败";  
  if(!is_uploaded_file($tmpname)){
	 return '需要移动的文件不存在';
  }  
  
  $newfilename=date("YmdHis").rand(100,999).".".$filetype;
  $newfilepath=$path."/".$newfilename;
  $savefilepath=dirname(__FILE__).'/'.$newfilepath;
    
  if(@move_uploaded_file($tmpname,$newfilepath)){
    @chmod($newfilepath, 0777);
    //$newfile['name']=$newfilename;
    //$newfile['size']=round($filesize/1024,2);
    return $filename."上传成功<script>window.parent.document.getElementById('imgurl').value='$newfilename';
	if(window.parent.document.getElementById('img')){window.parent.document.getElementById('img').src='$newfilepath';}</script>";
  }else{
    return "未知错误2，上传失败";
	//return $savefilepath;
  }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>文件上传</title>
<style type="text/css">
<!--
body{
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
body,td,th {
	font-family: 宋体, Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style></head>

<body>
<?php 
if($_FILES['pictures']){
	echo upfile ('pictures',$_POST['path'],1000,$_POST['type']);
	echo " <a href='javascript:history.back();'>重新上传</a>";
	exit();
}
?>
<form action="up.php" method="post" enctype="multipart/form-data">
  <input type="file" name="pictures" id="pictures"/>
  <input type="submit" value="上传" />
  <input type="hidden" name="path" id="path" value="<?php echo $path ?>"/>
  <input type="hidden" name="type" id="type" value="<?php echo $type ?>"/>
</form>
</body>
</html>
