<?php
require('../global.php');
require("common/action.class.php"); //用户操作类

//初始化数据库类
$db=new action();
$db->connect($mydbhost, $mydbuser, $mydbpw, $mydbname, 0, TRUE, $mydbcharset); //数据库操作类.

if(!empty($_POST['username'])&& !empty($_POST['password'])) $db->Get_user_login($_POST['username'],$_POST['password']);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GOCMS网站后台管理系统</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	overflow:hidden;
}
.STYLE3 {color: #528311; font-size: 12px; }
.STYLE4 {
	color: #42870a;
	font-size: 12px;
}
-->
</style>
<script language=javascript>
<!--
function CheckForm()
{
if(document.loginform.username.value=="")
{
alert("请输入管理员用户名！");
document.loginform.username.focus();
return false;
}
if(document.loginform.password.value=="")
{
alert("请输入管理员用户密码！");
document.loginform.admupwd.focus();
return false;
}
if (document.loginform.CheckCode.value==""){
       alert ("请输入您的验证码！");
       document.loginform.CheckCode.focus();
       return(false);
    }
}
//-->
</script>
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#e5f6cf">&nbsp;</td>
  </tr>
  <tr>
    <td height="608" background="images/login_03.gif"><table width="862" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="266" background="images/login_04.gif">&nbsp;</td>
      </tr>
      <tr>
        <td height="95"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="424" height="95" background="images/login_06.gif">&nbsp;</td>
            <td width="183" background="images/login_07.gif">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <form name="loginform" action="login.php" method="post" onSubmit="return CheckForm();">
                <tr>
                  <td width="21%" height="30"><div align="center"><span class="STYLE3">用户</span></div></td>
                  <td width="79%" height="30"><input name="username"  type="text"  id="username"  style="height:18px; width:130px; border:solid 1px #cadcb2; font-size:12px; color:#81b432;"></td>
                </tr>
                <tr>
                  <td height="30"><div align="center"><span class="STYLE3">密码</span></div></td>
                  <td height="30"><input name="password"  type="password" id="password"  style="height:18px; width:130px; border:solid 1px #cadcb2; font-size:12px; color:#81b432;"></td>
                </tr>
                <tr>
                  <td height="30">&nbsp;</td>
                  <td height="30"><input type="image" name="imageField" id="imageField" src="images/login.GIF">
                    <img src="images/reset.GIF" width="42" height="22" border="0" onClick="loginform.reset();"></td>
                </tr>
                </form>
              </table>        
            </td>
            <td width="255" background="images/login_08.gif">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="247" valign="top" background="images/login_09.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="22%" height="30">&nbsp;</td>
            <td width="56%">&nbsp;</td>
            <td width="22%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="44%" height="20">&nbsp;</td>
                <td width="56%" class="STYLE4">版本 2011V1.0 </td>
              </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#a2d962">&nbsp;</td>
  </tr>
</table>
</body>
</html>
