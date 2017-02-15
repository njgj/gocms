<?php include_once ('global.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>自动生成sql</title>
<link rel="stylesheet" href="../include/styles/agate.css">
<script src="../include/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif, "宋体";
	font-size: 12px;
}
</style>
</head>

<body>
<form id="form1" name="form1" method="post" action="makesql.php">
  <input type="text" name="tablename" id="tablename" placeholder="数据库表名"/>
  <input type="submit" name="button" id="button" value="提交" />
  <input type="hidden" name="action" id="action" value="Ok"/>
</form>
<pre>
<code class="php">  
<?php 
   $tablename=$_POST['tablename'];
   if($_POST['action']=='Ok' ){
		 if(empty($tablename)) {  
		   htmlendjs('请输入表名','');
		 }
        $sql="select COLUMN_NAME,DATA_TYPE from information_schema.COLUMNS where table_name = '".$tablename."'";
		$rs=$db->query($sql);
		while($row=$db->fetch_array($rs)){
			if(strtolower($row['COLUMN_NAME'])!='id'){
				
				$zd.=$row['COLUMN_NAME'].',';
				$zd4.='$'.$row['COLUMN_NAME'].'=$row[\''.$row['COLUMN_NAME'].'\'];<br>';
				
				if($row['DATA_TYPE']=='varchar'){
				   $str.='$'.$row['COLUMN_NAME'].'=trim($_POST["'.$row['COLUMN_NAME'].'"]);<br>';
				   $pd1.='$'.$row['COLUMN_NAME'].',';
				   $pd2.='if(empty($'.$row['COLUMN_NAME'].')){ htmlendjs("不能为空",""); }<br>'; 
				   $zd2.="'$".$row['COLUMN_NAME']."',";
				   $zd3.=$row['COLUMN_NAME']."='$".$row['COLUMN_NAME']."',";
				}
				if($row['DATA_TYPE']=='text'){
				   $str.='$'.$row['COLUMN_NAME'].'=$_POST["'.$row['COLUMN_NAME'].'"];<br>';
				   $pd1.='$'.$row['COLUMN_NAME'].',';
				   $pd2.='if(empty($'.$row['COLUMN_NAME'].')){ htmlendjs("不能为空",""); }<br>'; 
				   $zd2.="'$".$row['COLUMN_NAME']."',";
				   $zd3.=$row['COLUMN_NAME']."='$".$row['COLUMN_NAME']."',";
				}
				if($row['DATA_TYPE']=='int' or $row['DATA_TYPE']=='tinyint'){
				   $str.='$'.$row['COLUMN_NAME'].'=(int)$_POST["'.$row['COLUMN_NAME'].'"];<br>';
				   //$pd2.='if(empty($'.$row['COLUMN_NAME'].')){ $'.$row['COLUMN_NAME'].'=0; }<br>'; 
				   $zd2.="$".$row['COLUMN_NAME'].",";
				   $zd3.=$row['COLUMN_NAME']."=$".$row['COLUMN_NAME'].",";
				}
				
				if($row['DATA_TYPE']=='float'){
				   $str.='$'.$row['COLUMN_NAME'].'=(float)$_POST["'.$row['COLUMN_NAME'].'"];<br>';
				   $zd2.="$".$row['COLUMN_NAME'].",";
				   $zd3.=$row['COLUMN_NAME']."=$".$row['COLUMN_NAME'].",";
				}
				
				if($row['DATA_TYPE']=='datetime'){
				   $str.='$'.$row['COLUMN_NAME'].'=$_POST["'.$row['COLUMN_NAME'].'"];<br>';
				   $pd1.='$'.$row['COLUMN_NAME'].',';
				   $pd2.='if(empty($'.$row['COLUMN_NAME'].')){ $'.$row['COLUMN_NAME'].'=date(\'Y-m-d H:i:s\'); }<br>'; 
				   $zd2.="'$".$row['COLUMN_NAME']."',";
				   $zd3.=$row['COLUMN_NAME']."='$".$row['COLUMN_NAME']."',";
				}	
			}
			$td.='<td height="50">&lt;?php echo $'.$row['COLUMN_NAME'].'; ?&gt;</td>';
		}
		if($pd1){ $pd1=substr($pd1,0,strlen($pd1)-1);  }
		if($zd){ $zd=substr($zd,0,strlen($zd)-1);  }		
		if($zd2){ $zd2=substr($zd2,0,strlen($zd2)-1);  }
		if($zd3){ $zd3=substr($zd3,0,strlen($zd3)-1);  }
   }
?>
//参数
$id=(int)$_GET['id'];
$action=$_POST['action'];
<?php echo $str; ?>
//初始化
$act='add';
function init(){
global <?php echo $pd1; ?>;
<?php echo $pd2;?>
}
//操作
if($action=='add'){
    init();
    $db->query("INSERT INTO <?php echo $tablename ?>(<?php echo $zd; ?>) VALUES(<?php echo $zd2; ?>)");	
    htmlendjs('添加成功','<?php echo str_replace('g_','',$tablename); ?>_add.php');
}
if($action=='edit'){
    init();
    $db->query("update <?php echo $tablename ?> set <?php echo $zd3; ?> where id=$id");	
    htmlendjs('修改成功','open');
}
//赋值
if(!empty($id)){
    $rs=$db->query("select * from <?php echo $tablename ?> where id=$id");
    $row = $db -> fetch_array($rs);
    if($row){
    <?php echo $zd4; ?>
    $act='edit';
    }
    
}
//表单
<table border=1>
<tr><?php echo $td; ?></tr>
</table>
&lt;input type=&quot;hidden&quot; name=&quot;action&quot; id=&quot;action&quot; value=&quot;&lt;?php echo $act; ?&gt;&quot;/&gt;
//管理
$action=$_GET['action'];
$id=(int)$_GET['id'];
$states=(int)$_GET['states'];
$classid=(int)$_GET['classid'];
$key=trim($_GET['key']);

if($action=='chk'){
	$db->query("update <?php echo $tablename ?> set states=$states where id=$id");
	htmlendjs("操作成功","open");
}
if($action=='del'){	
	$db->query("DELETE FROM <?php echo $tablename ?> WHERE id =$id LIMIT 1");
	htmlendjs("删除成功","open");
}
</code>
</pre>

</body>
</html>

















