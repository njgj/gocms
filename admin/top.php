<?php
require("global.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="css/iconfont.css" rel="stylesheet" type="text/css">
<style type="text/css">
body,ul,ol,li,h1,h2,h3,h4,h5,h6,form,fieldset,img,div,tr{margin:0;padding:0;}
ul li{ list-style-type:none; vertical-align:middle; }
body,td,th {
	font-family: 宋体, Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.topmenu  { float:right; height:48px; overflow:hidden; }
.topmenu ul li { float:left; }
.topmenu ul li a { display:block; color:#360; text-decoration:none; width:70px; height:48px; text-align:center; overflow:hidden; position:relative; }
.topmenu ul li a i { font-size:24px; display:block; height:24px; width:70px; position:absolute; left:0; top:5px; }
.topmenu ul li a div { position:absolute; width:70px; left:0; top:30px; text-align:center; }
.topmenu ul li a.on,.topmenu ul li a:hover { background:#579608; color:#FFF !important; }
</style>
<script>
function exit(){
	if(confirm('确定要退出系统吗？')){
		//window.onbeforeunload = null;
		//$.cookie('isClose',null);
		window.location='loginout.php';
	}
}
</script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="11" background="images/main_03.gif"><img src="images/main_01.gif" width="104" height="11"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  background="images/main_07.gif">
      <tr>
        <td width="282" height="52" background="images/main_05.gif">&nbsp;</td>
        <td valign="top">
                <div class="topmenu">
                <ul>
                <li><a href="welcome.php" target="main"><i class="iconfont">&#xe643; </i><div>欢迎界面</div></a></li>
                <li><a href="../index.php" target="top" class="on"><i class="iconfont">&#xe616; </i><div>返回首页</div></a></li>
                <li><a href="user/user_my_edit.php" target="main"><i class="iconfont">&#xe60b; </i><div>个人信息</div></a></li>
                <li><a href="user/user_pwd.php" target="main"><i class="iconfont">&#xe610; </i><div>修改密码</div></a></li>
                <li><a href="javascript:;" onClick="top.mainFrame.main.location.reload()"><i class="iconfont">&#xe625; </i><div>刷新</div></a></li>
                <!--<li><a href="javascript:;" onClick="main.history.back(-1);"><i class="iconfont">&#xe698; </i><div>返回</div></a></li>-->
                <li><a href="#" onClick="exit();"><i class="iconfont">&#xe628; </i><div>退出</div></a></li>
                </ul>
                </div>
        
        </td>
        <td width="283" background="images/main_09.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right"><img src="images/uesr.gif" width="14" height="14">当前登录用户：<?php echo $db -> get_one("select username from g_user where userid=".$_SESSION['userid']);  ?>&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/home.gif" width="12" height="13">角色：<?php echo $db -> get_one("select groupname from g_user_group where groupid=".$_SESSION['groupid']);  ?>&nbsp;&nbsp;&nbsp;</td>
            </tr>
        </table></td>
      </tr>
    </table>
</body>
</html>
