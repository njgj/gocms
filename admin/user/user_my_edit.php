<?php
include_once ('../global.php');

if($_POST['edit']){
	if(empty($_POST['username'])){
		htmlendjs('用户名不能为空！','');
	}
	if(empty($_POST['realname'])){
		htmlendjs('姓名不能为空！','');
	}	
	if($db->get_one("select * from g_user where username='$_POST[username]' and username<>'$_POST[oldusername]'")){
	    htmlendjs('用户名已被注册！','');
	}
	$sql="update g_user set username='$_POST[username]',realname='$_POST[realname]',addtime='".date('Y-m-d H:i:s')."' where userid=".$_SESSION['userid'];

	$db->query($sql);	
	htmlendjs("修改成功","open");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>修改个人信息</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="../css/style.css" type=text/css rel=stylesheet>
<script type="text/javascript" src="../../include/validator.js"></script>
</HEAD>
<BODY>
<form action="user_my_edit.php" method="post" onSubmit="return Validator.Validate(this,3)">
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="15" height="30"><img src="../images/tab_03.gif" width="15" height="30" /></td>
        <td background="../images/tab_05.gif"><img src="../images/311.gif" width="16" height="16" /><span class="title">修改个人信息</span></td>
        <td width="14"><img src="../images/tab_07.gif" width="14" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="9" background="../images/tab_12.gif">&nbsp;</td>
        <td height="150" bgcolor="#F3FFE3">
        <?php 
		$sql = "select * from g_user where userid=".$_SESSION['userid'];
		$query = $db -> query($sql);
		if($row = $db -> fetch_array($query)){	
		?>
        <table width="98%" border=0 align=center cellpadding="0" cellspacing=1 >  
          <tr>
            <td align="right">用户名:</td>
            <td><input type="text" name="username" id="username" datatype="Username" msg="以字母或中文开头至少2位" value="<?php echo $row['username'] ?>"/>            </td>
          </tr>
          <tr>
            <td align="right">真实姓名:</td>
            <td><input type="text" name="realname" id="realname" datatype="Require" msg="真实姓名不能为空" value="<?php echo $row['realname'] ?>"/>            </td>
          </tr>
          <tr>
            <td colspan="2" align="center" height='30'>
            <input name="edit" type="submit" class="btn" value=" 修改 "/> 
            <input type="hidden" name="oldusername" id="oldusername" value="<?php echo $row['username'] ?>">                    </td>
          </tr>
        </table>
        <?php } ?>
        </td>
        <td width="9" background="../images/tab_16.gif">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="29"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="15" height="29"><img src="../images/tab_20.gif" width="15" height="29" /></td>
        <td background="../images/tab_21.gif">&nbsp;</td>
        <td width="14"><img src="../images/tab_22.gif" width="14" height="29" /></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</BODY>
</HTML>

