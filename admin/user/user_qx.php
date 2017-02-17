<?php 
require('../global.php');
chk_admin('1');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户权限</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<br />
<p align="center"><img src="../images/tb.gif" width="16" height="16" />&nbsp;<a href="?action=">权限列表</a>&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/add.gif" width="14" height="14" />&nbsp;<a href="?action=add">添加权限</a></p>
<?php
switch($_GET['action']){
    case 'order':
	    if(!is_numeric($_POST['orderid'])){
	    	htmlendjs('排序不能为空且为数字！','');
	    }
		$sql = "update g_user_qx set orderid=$_POST[orderid] where classid=$_GET[classid]";
		$db -> query($sql);
		echo "<script>window.location='?action='</script>";
		break;
	case 'add':
		$class_arr=array();
		$sql = "select * from g_user_qx order by orderid";
		$query = $db -> query($sql);
		while($row = $db -> fetch_array($query)){
			$class_arr[] = array($row['classid'],$row['classname'],$row['parentid'],$row['orderid']);
		}
		?>
<form action="?action=act_add" method="post">
<table width="600" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#D9F1BA" class="table02">
<thead>
        <tr>
          <td height="25" colspan="2" align="center" background="../images/tab_14.gif">添加权限</td>
        </tr>
      </thead>
    <tr>
      <td height="25" align="right" bgcolor="#FFFFFF">权限名称：</td>
      <td height="25" bgcolor="#FFFFFF"><input name="classname" type="text" id="classname" value="" size="40" /></td>
    </tr>
      <tr>
        <td height="25" align="right" bgcolor="#FFFFFF">所属分类ID：</td>
        <td height="25" bgcolor="#FFFFFF"><select name="parentid" id="parentid">
        <option value="0">-----顶级分类-----</option>
            <?php
            	echo nclass_select($class_arr,0,0,$_GET['classid']);
			?>
          </select>        </td>
    </tr>
      <tr>
        <td height="25" align="right" bgcolor="#FFFFFF">图标：</td>
        <td height="25" bgcolor="#FFFFFF"><input type="text" name="imgurl" id="imgurl"/><iframe frameborder="0" scrolling="no" src="../common/up.php" width="100%" height="25"></iframe>
    </td>
      </tr>
      <tr>
        <td height="25" align="right" bgcolor="#FFFFFF">URL：</td>
        <td height="25" bgcolor="#FFFFFF"><input name="url" type="text" id="url" value="" size="40" />
        <input name="isnew" type="checkbox" id="isnew" value="1" />
        新窗口</td>
      </tr>
      <tr>
        <td height="25" align="right" bgcolor="#FFFFFF">排序：</td>
        <td height="25" bgcolor="#FFFFFF"><input name="orderid" type="text" id="orderid" size="6" /></td>
    </tr>
      <tr>
        <td height="25" colspan="2" align="center" bgcolor="#FFFFFF">
          <input type="submit" name="button" id="button" value="添加权限" />
        <input type="reset" name="button2" id="button2" value="重置" />        </td>
    </tr>
  </table>
</form>
  <?php
		break;
	case 'act_add':
	    if(!$_POST['classname']){
	    	htmlendjs('权限名称不能为空！','');
	    }
		if(!$_POST['url']){
	    	htmlendjs('URL不能为空！','');
	    }
		if(!is_numeric($_POST['orderid'])){
	    	htmlendjs('排序不能为空且为数字！','');
	    }
		$isnew=(!$_POST['isnew'])?0:$_POST['isnew'];
		$sql = "INSERT INTO g_user_qx (classname,parentid,imgurl,url,isnew,orderid) VALUES('".$_POST['classname']."',".$_POST['parentid'].",'".$_POST['imgurl']."','".$_POST['url']."',".$isnew.",".$_POST['orderid'].")";
		$db -> query($sql);
		savepath($db->insert_id(),$parentid);//更新classpath路径
		htmlendjs('添加成功!','?action=');
		break;
	case 'edit':
		$class_arr=array();
		$sql = "select * from g_user_qx order by orderid";
		$query = $db -> query($sql);
		while($row = $db -> fetch_array($query)){
			$class_arr[] = array($row['classid'],$row['classname'],$row['parentid'],$row['orderid']);
		}
	$sql  = "select * from g_user_qx where classid=".$_GET['classid'];
	$query = $db -> query($sql);
	$row = $db -> fetch_array($query);
	if($row){
	?>
      <form action="?action=act_edit" method="post">
    <table width="600" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#D9F1BA" class="table02">
      <thead>
        <tr>
          <td height="25" colspan="2" align="center" background="../images/tab_14.gif">修改权限</td>
        </tr>
      </thead>
      <tr>
        <td height="25" align="right" bgcolor="#FFFFFF">权限名称：</td>
        <td height="25" bgcolor="#FFFFFF"><input name="classname" type="text" id="classname" value="<?php echo $row['classname'];?>" size="40" /></td>
      </tr>
      <tr>
        <td height="25" align="right" bgcolor="#FFFFFF">所属分类ID：</td>
        <td height="25" bgcolor="#FFFFFF"><select name="parentid" id="parentid">
        <option value="0">-----顶级分类-----</option>
            <?php
            	echo nclass_select($class_arr,0,0,$row['parentid']);
			?>
          </select>        </td>
      </tr>
      <tr>
        <td height="25" align="right" bgcolor="#FFFFFF">图标：</td>
        <td height="25" bgcolor="#FFFFFF"><input type="text" name="imgurl" id="imgurl" value="<?php echo $row['imgurl'] ?>"/><iframe frameborder="0" scrolling="no" src="../common/up.php" width="100%" height="25"></iframe></td>
      </tr>
      <tr>
        <td height="25" align="right" bgcolor="#FFFFFF">URL：</td>
        <td height="25" bgcolor="#FFFFFF"><input name="url" type="text" id="url" value="<?php echo $row['url']; ?>" size="40" />
          <input name="isnew" type="checkbox" id="isnew" value="1" <?php if($row['isnew']==1){echo 'checked';} ?>/>
新窗口</td>
      </tr>
      <tr>
        <td height="25" align="right" bgcolor="#FFFFFF">排序：</td>
        <td height="25" bgcolor="#FFFFFF"><input name="orderid" type="text" id="orderid" value="<?php echo $row['orderid'];?>" size="25" /></td>
      </tr>
      <tr>
        <td height="25" colspan="2" align="center" bgcolor="#FFFFFF">
        <input type="submit" name="button" id="button" value="修改权限" />
            <input type="hidden" id="classid" name="classid" value="<?php echo $_GET['classid'];?>" />
        <input type="button" value="返回" onclick="history.back();"/>        </td>
      </tr>
    </table>
</form>
<?php
	}else{
		htmlendjs('要修改的记录不存在!','?action=');
	}
		break;
	case 'act_edit':
		if(!$_POST['classname']){
	    	htmlendjs('权限名称不能为空！','');
	    }
		if(!$_POST['url']){
	    	htmlendjs('URL不能为空！','');
	    }
		if(!is_numeric($_POST['orderid'])){
	    	htmlendjs('排序不能为空且为数字！','');
	    }
		$isnew=(!$_POST['isnew'])?0:$_POST['isnew'];
		$sql  = "select classid from g_user_qx where classid=".$_POST['classid'];
		$query = $db -> query($sql);
		$row = $db -> fetch_array($query);
		if($row){
			if($row['classid']==$_POST['parentid']){
				htmlendjs('修改失败,不能自己是自己的子权限!','');
			}else{
				$sql = "update g_user_qx set classname='".$_POST['classname']."',parentid=".$_POST['parentid'].",imgurl='".$_POST['imgurl']."',url='".$_POST['url']."',isnew=".$isnew.",orderid=".$_POST['orderid']." where classid=".$_POST['classid'];
				$db -> query($sql);
				savepath($_POST['classid'],$_POST['parentid']);//更新classpath路径
				htmlendjs('修改成功!','?action=');
			}
		}
		break;
	case 'del':
		if(delclass($_GET['classid'])){
			htmlendjs('删除成功!','?action=');
		};	
		break;
	case '':
		$class_arr=array();
		$sql = "select * from g_user_qx order by orderid";
		$query = $db -> query($sql);
		while($row = $db -> fetch_array($query)){
			$class_arr[] = array($row['classid'],$row['classname'],$row['parentid'],$row['orderid'],$row['url'],$row['imgurl']);
		}
		?>
    <table width="800" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#D9F1BA">
    <tr>
      <td width="44" align="center" background="../images/tab_14.gif" >ID</td>
      <td width="222" height="25" align="center" background="../images/tab_14.gif" >权限名称</td>
      <td width="125" align="center" background="../images/tab_14.gif">图标</td>
      <td width="125" align="center" background="../images/tab_14.gif">URL</td>
      <td width="108" height="25" align="center" background="../images/tab_14.gif">排序</td>
      <td width="169" height="25" align="center" background="../images/tab_14.gif">操作</td>
      </tr>
      <?php nclass_arr(0,0);?>
</table>
<?php
		break;

}
?>

</body>
</html>
<?php
//$class_arr[] = array($row['classid'],$row['classname'],$row['parentid'],$row['orderid']);
//$m:填充长度 $fid:父类ID
function nclass_arr($m=0,$fid=0)
{
	global $class_arr;
	if($fid=="") $fid=0;
	$n = str_pad('',$m,'-',STR_PAD_RIGHT);
	$n = str_replace("-","&nbsp;&nbsp;&nbsp;",$n);
	for($i=0;$i<count($class_arr);$i++){
		if($class_arr[$i][2]==$fid){
		echo "<tr bgcolor=\"#FFFFFF\" onMouseMove=\"this.style.backgroundColor='#F0F8FF'\" onMouseOut=\"this.style.backgroundColor='#FFFFFF'\">\n";
		echo "	  <td align=center  height=25>".$class_arr[$i][0]."</td>\n";
		echo "	  <td align=left>".$n."├ <a href=\"?action=edit&classid=".$class_arr[$i][0]."\">".$class_arr[$i][1]."</a></td>\n";
		if ($class_arr[$i][5]){
		echo "	  <td align=center><img src='../../uploadfile/icon/".$class_arr[$i][5]."' height=20 onclick='window.open(this.src)' style='cursor:hand'></td>\n";}
		else{
		echo "	  <td align=center>&nbsp;</td>\n";}
		echo "	  <td align=center><a href=\"".$class_arr[$i][4]."\" target='_blank'>".$class_arr[$i][4]."</a></td>\n";
		echo "	  <td align=center><form action='?action=order&classid=".$class_arr[$i][0]."' method='post'><input type='text' name='orderid' size=3 value=".$class_arr[$i][3]."><input type='submit' value='修改'></form></td>\n";
		echo "	  <td align=center><img src=\"../images/write.gif\" width=9 height=9 />[<a href=\"?action=add&classid=".$class_arr[$i][0]."\">新增</a>]";
		echo " <img src=\"../images/write.gif\" width=9 height=9 />[<a href=\"?action=edit&classid=".$class_arr[$i][0]."\">修改</a>]";
		echo " <img src=\"../images/del.gif\" width=9 height=9 />[<a href=\"?action=del&classid=".$class_arr[$i][0]."\" onClick=\"return confirm('删除《".$class_arr[$i][1]."》，是否确定？');\">删除</a>]";
		echo "</td>\n";
		echo "</tr>\n";		
			nclass_arr($m+1,$class_arr[$i][0]);
		}		
	}	
}

//级联删除分类及其子分类
function delclass($classid){
	global $db;
    if($classid){
		//$classpath=getClassPath('g_nclass_link',$classid); 
		//$db->query("delete from g_news where classid in (select classid from g_class where locate(',$classid,',classpath)>0)");
		$db->query("delete from g_user_qx where locate(',$classid,',classpath)>0");
		return true;
	}else{
		return false;
	}
	return false;
}

//保存classpath路径,newid:当前插入操作ID
function savepath($newid,$parentid){
	global $db;
	if(empty($newid)){ return false; }
	if($parentid==0){ 
		$classpath='0,'.$newid.',';
	}else{
		$sql='select classpath from g_user_qx where classid='.(int)$parentid;
		$query = $db -> query($sql);
		if($row = $db -> fetch_array($query)){
			$classpath=$row['classpath'].$newid.','; //父节点的路径	
		}
	}
	return $db -> query("update g_user_qx set classpath='$classpath' where classid=".(int)$newid);
}
?>