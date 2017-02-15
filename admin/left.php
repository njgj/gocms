<?php
include_once ("global.php");
$qx=$db -> get_one("select qx from g_user_group where groupid=".$_SESSION['groupid']);
if(empty($qx)){ exit('没有权限'); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>左侧菜单</title>
<style type="text/css">
html { overflow-x: hidden; overflow-y: auto; }
/*定义滚动条高宽及背景 高宽分别对应横竖滚动条的尺寸*/  
::-webkit-scrollbar  
{  
    width: 12px; 
    background-color: #FFF;  
}  
  
/*定义滚动条轨道 内阴影+圆角*/  
::-webkit-scrollbar-track  
{  
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);  
    background-color: #FFF;  
}  
  
/*定义滑块 内阴影+圆角*/  
::-webkit-scrollbar-thumb  
{  
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);  
    background-color:#333;  
}  

ul,h2 { margin:0px; padding:0px; }
body,td,th {
	font-family: "宋体", Arial, Verdana, sans-serif;
	font-size: 12px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	
	_background-image:url(about:blank);
	_background-attachment:fixed;/*防止页面抖动*/
}
img { border:0; }
.fix { position:fixed; _position:absolute; top:0px; _top: expression(documentElement.scrollTop + 0 + "px"); left:0px; z-index:9999;  }

.container { width:170px; height:auto; overflow:hidden; }
.head { width:170px; height:20px; line-height:20px; text-indent:30px; color:#FFF; font-size:16px; font-family:微软雅黑; background:url(Images/main_11.gif) repeat-x; overflow:hidden;}

.content { width:170px; position:absolute; top:20px; overflow:hidden; }
.menu h2 { height:26px; line-height:26px; color:#FFF; font-size:14px; font-weight:normal;  text-indent:50px; cursor:pointer; background:url(Images/menuoff.gif) repeat-x;}
.menu ul { list-style:none; display:none; padding:10px 0; background:#F6FEEB; }
.menu ul li { }
.menu ul li a { display:block;  width:170px; padding-left:50px; height:26px; line-height:26px; text-decoration:none;  font-size:14px; color:#111;   overflow:hidden; }
.menu ul li a:hover,.menu ul li.on { font-weight:bold; background:#D9F1BA; color:#000;  }

.chgbg { background:url(Images/menuon.gif) left bottom !important; }
</style>
<script type="text/javascript" src="../include/jquery-1.8.3.min.js"></script>   
<script type="text/javascript">
$(document).ready(function(e) {

/*	$("h2").last().toggleClass('chgbg');
	$("ul").last().show();*/

	$(".head").click(function(){
	    $(".menu > h2").toggleClass('chgbg');
		$(".menu > ul").toggle();
	});

	$(".menu").find("h2").click(function(){
	    $(this).toggleClass('chgbg');
		$(this).parent().find("ul").toggle();
		
	});
	
	$(".menu li").click(function(){
		 $(".menu li").removeClass("on");
	     $(this).addClass("on");
	});
});
</script>

</head>

<body>
<div class="container">
    <div class="head fix"></div>
    <div class="content">
      <?php 
		$sql="select * from g_user_qx where parentid=0 and classid in ($qx) order by orderid";
		$query = $db -> query($sql);
		$i=0;
		while($row = $db -> fetch_array($query)){	
	  ?>
        <div class="menu">
            <h2><?php echo $row['classname'] ?></h2>
            <ul>
           <?php 
            $sql="select * from g_user_qx where parentid=$row[classid] and classid in ($qx) order by orderid";
            $query2 = $db -> query($sql);
            while($row2 = $db -> fetch_array($query2)){	
          ?>
            <li><a href="<?php echo $row2['url'] ?>" target="main"><?php echo $row2['classname'] ?></a></li>
             <?php }?>
             </ul>
        </div>
    <?php 
	$i++;
	}?> 
    </div>
</div>
</body>
</html>