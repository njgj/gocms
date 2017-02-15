<?php 
header('content-type:text/html;charset=utf-8');
include('upload.class.php'); 
if($_FILES['pictures']){
echo $_FILES['pictures'][name].'<br>';
echo $_FILES['pictures'][type].'<br>';
echo $_FILES['pictures'][size].'B<br>';
echo $_FILES['pictures'][tmp_name].'<br>';
echo $_FILES['pictures'][error].'<br>';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<form action="upload.php" method="post" enctype="multipart/form-data">
  <p>
    <input type="file" name="pictures" />

<input type="submit" value="Send" />
</p>
</form>

</body>
</html>
