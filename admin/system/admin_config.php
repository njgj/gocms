<?php
require('../global.php');
chk_admin('1');

$path='../../configs/config.php';

if($_POST['update']){
	file_put_contents($path,stripslashes($_POST['content']));
} 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>网站配置</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="../css/style.css" type=text/css rel=stylesheet>
</HEAD>
<BODY>
<form action="admin_config.php" method="post" >
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="15" height="30"><img src="../images/tab_03.gif" width="15" height="30" /></td>
        <td background="../images/tab_05.gif"><img src="../images/tb.gif" width="16" height="16" /><span class="title">网站配置</span></td>
        <td width="14"><img src="../images/tab_07.gif" width="14" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="9" background="../images/tab_12.gif">&nbsp;</td>
        <td height="200" bgcolor="#F3FFE3"><table width="98%" border=0 align=center cellspacing=1 >
          <tr>
            <td align="center" height='30'><textarea name="content" id="content" cols="80" rows="20"><?php echo file_get_contents($path) ?></textarea></td>
          </tr>
          <tr>
            <td align="center" height='30'><input name="update" type="submit" class="btn" value=" 保存 "/>            </td>
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
</form>
</BODY>
</HTML>
