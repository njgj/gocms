<?php 
require('../global.php');
chk_admin('1');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户用户组</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../include/common.js"></script>
</head>
<body>
<br />
<p align="center"><img src="../images/tb.gif" width="16" height="16" />&nbsp;<a href="?action=">用户组列表</a>&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/add.gif" width="14" height="14" />&nbsp;<a href="?action=add">添加用户组</a></p>
<?php
switch($_GET['action']){
    case 'order':
	    if(!is_numeric($_POST['orderid'])){
	    	htmlendjs('排序不能为空且为数字！','');
	    }
		$sql = "update g_user_group set orderid=$_POST[orderid] where groupid=$_GET[groupid]";
		$db -> query($sql);
		echo "<script>window.location='?action='</script>";
		break;
	case 'add':
		?>
<form action="?action=act_add" method="post">
<table width="600" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#D9F1BA" class="table02">
<thead>
        <tr>
          <td height="25" colspan="2" align="center" background="../images/tab_14.gif">添加用户组</td>
        </tr>
    </thead>
    <tr>
      <td height="25" align="right" bgcolor="#FFFFFF">用户组名称：</td>
      <td height="25" bgcolor="#FFFFFF"><input name="groupname" type="text" id="groupname" value="" /></td>
    </tr>
      <tr>
        <td height="25" align="right" bgcolor="#FFFFFF">备注：</td>
        <td height="25" bgcolor="#FFFFFF"><input name="remark" type="text" id="remark" value="" size="50" /></td>
      </tr>
      <tr>
        <td height="25" align="right" bgcolor="#FFFFFF">排序：</td>
        <td height="25" bgcolor="#FFFFFF"><input name="orderid" type="text" id="orderid" size="6" /></td>
    </tr>
      <tr>
        <td height="25" colspan="2" align="center" bgcolor="#FFFFFF">
          <input type="submit" name="button" id="button" value="添加用户组" />
        <input type="reset" name="button2" id="button2" value="重置" />        </td>
    </tr>
  </table>
</form>
  <?php
		break;
	case 'act_add':
	    if(!$_POST['groupname']){
	    	htmlendjs('用户组名称不能为空！','');
	    }
		if(!is_numeric($_POST['orderid'])){
	    	htmlendjs('排序不能为空且为数字！','');
	    }
		$sql = "INSERT INTO g_user_group (groupname,remark,orderid) VALUES('".$_POST['groupname']."','".$_POST['remark']."',".$_POST['orderid'].")";
		$db -> query($sql);
		htmlendjs('添加成功!','?action=');
		break;
	case 'edit':
	$sql  = "select * from g_user_group where groupid=".$_GET['groupid'];
	$query = $db -> query($sql);
	$row = $db -> fetch_array($query);
	if($row){
	?>
      <form action="?action=act_edit" method="post">
    <table width="600" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#D9F1BA" class="table02">
      <thead>
        <tr>
          <td height="25" colspan="2" align="center" background="../images/tab_14.gif">修改用户组</td>
        </tr>
      </thead>
      <tr>
        <td height="25" align="right" bgcolor="#FFFFFF">用户组名称：</td>
        <td height="25" bgcolor="#FFFFFF"><input name="groupname" type="text" id="groupname" value="<?php echo $row['groupname'];?>" /></td>
      </tr>
      <tr>
        <td height="25" align="right" bgcolor="#FFFFFF">备注：</td>
        <td height="25" bgcolor="#FFFFFF"><input name="remark" type="text" id="remark" value="<?php echo $row['remark']; ?>" size="50" /></td>
      </tr>
      <tr>
        <td height="25" align="right" bgcolor="#FFFFFF">排序：</td>
        <td height="25" bgcolor="#FFFFFF"><input name="orderid" type="text" id="orderid" value="<?php echo $row['orderid'];?>" size="25" /></td>
      </tr>
      <tr>
        <td height="25" colspan="2" align="center" bgcolor="#FFFFFF">
        <input type="submit" name="button" id="button" value="修改用户组" />
        <input type="hidden" id="groupid" name="groupid" value="<?php echo $_GET['groupid'];?>" />
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
		if(!$_POST['groupname']){
	    	htmlendjs('用户组名称不能为空！','');
	    }
		if(!is_numeric($_POST['orderid'])){
	    	htmlendjs('排序不能为空且为数字！','');
	    }
		$sql = "update g_user_group set groupname='".$_POST['groupname']."',remark='".$_POST['remark']."',orderid=".$_POST['orderid']." where groupid=".$_POST['groupid'];
		$db -> query($sql);
		htmlendjs('修改成功!','?action=');
		break;
	case 'del':
			$sql  = "select * from g_user_group where groupid=".$_GET['groupid'];
			$query = $db -> query($sql);
			$row = $db -> fetch_array($query);
			if($row){
				$db -> query("delete from g_user_group where groupid=".$_GET['groupid']);
				htmlendjs('删除成功!','?action=');
			}else{
				htmlendjs('记录不存在!','?action=');
			}
		break;
	case '':
		?>
    <table width="674" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#D9F1BA">
    <tr>
      <td width="44" align="center" background="../images/tab_14.gif" >ID</td>
      <td width="222" height="25" align="center" background="../images/tab_14.gif" >用户组名称</td>
      <td width="156" align="center" background="../images/tab_14.gif">备注</td>
      <td width="117" height="25" align="center" background="../images/tab_14.gif">排序</td>
      <td width="129" height="25" align="center" background="../images/tab_14.gif">操作</td>
      </tr>
      <?php 
		$sql = "select * from g_user_group order by orderid";
		$query = $db -> query($sql);
		while($row = $db -> fetch_array($query)){	
	  ?>
    <tr>
      <td align="center" bgcolor="#FFFFFF" ><?php echo $row['groupid'] ?></td>
      <td height="25" align="center" bgcolor="#FFFFFF" ><?php echo $row['groupname'] ?></td>
      <td align="center" bgcolor="#FFFFFF"><?php echo $row['remark'] ?></td>
      <td height="25" align="center" bgcolor="#FFFFFF"><form action='?action=order&groupid=<?php echo $row['groupid'] ?>' method='post'><input type='text' name='orderid' size=5 value='<?php echo $row['orderid'] ?>'><input type='submit' value='修改'></form></td>
      <td height="25" align="center" bgcolor="#FFFFFF"><img src="../images/write.gif" width="9" height="9" />[<a href="javascript:void(0);" onClick="newwin('user_group_qx.php?groupid=<?php echo $row['groupid']?>',200,400)">权限分配</a>]</td>
    </tr>
    <?php }?>
</table>
<?php
		break;

}
?>

</body>
</html>
