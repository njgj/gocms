<?php
require('../global.php');
$userid=$_GET['userid'];
if(empty($userid)){ htmlendjs("参数错误","close"); }

$sql = "select * from g_user where userid=$userid";
$query = $db -> query($sql);
if($row = $db -> fetch_array($query)){	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>详细信息</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="../css/style.css" type=text/css rel=stylesheet>
</HEAD>
<BODY>
<table width="380" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="15" height="30"><img src="../images/tab_03.gif" width="15" height="30" /></td>
        <td background="../images/tab_05.gif"><img src="../images/tb.gif" width="16" height="16" /><span class="title">详细信息</span></td>
        <td width="14"><img src="../images/tab_07.gif" width="14" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="9" background="../images/tab_12.gif">&nbsp;</td>
        <td bgcolor="#F3FFE3"><table width="98%" border=0 align=center cellpadding="0" cellspacing=1 >
          <tr>
            <td width="31%" height="24" align="right">用户名:</td>
            <td width="69%" height="24"><?php echo $row['username'] ?></td>
          </tr>
          <tr>
            <td height="24" align="right">用户组:</td>
            <td height="24"><?php echo $db->get_one('select groupname from g_user_group where groupid='.$row['groupid']) ?></td>
          </tr>

          <tr>
            <td height="24" align="right">真实姓名:</td>
            <td height="24"><?php echo $row['realname'] ?></td>
          </tr>
          <tr>
            <td height="24" align="right">添加时间:</td>
            <td height="24"><?php echo $row['addtime'] ?></td>
          </tr>
          <tr>
            <td height="24" align="right">最后一次登录时间:</td>
            <td height="24"><?php echo $row['lastlogintime'] ?></td>
          </tr>
          <tr>
            <td height="24" align="right">最后一次登录IP:</td>
            <td height="24"><?php echo $row['lastloginip'] ?></td>
          </tr>
          <tr>
            <td height="24" align="right">状态:</td>
            <td height="24"><?php echo chkstates($row['states']) ?></td>
          </tr>
          
        </table></td>
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
</BODY>
</HTML>
<?php } ?>