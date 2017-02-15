<?php 
include_once ('../global.php');

$groupid=$_GET['groupid'];
if($_GET['action']=='edit'){
    $db->query("update g_user_group set qx='".$_POST['qx']."' where groupid=".$groupid);
	htmlendjs("修改成功","close");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>权限分配</title>
<script language="javaScript" src="../../include/MzTreeView12.js"></script>
<style>
body {
	margin-left: 3px;
	margin-top: 0px;
	margin-right: 3px;
	margin-bottom: 0px;
}
body,td,th {
	font-family: 宋体, Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
a.MzTreeview /* TreeView 链接的基本样式 */ { cursor: hand; color: #000080; margin-top: 5px; padding: 2 1 0 2; text-decoration: none; }
.MzTreeview a.select /* TreeView 链接被选中时的样式 */ { color: highlighttext; background-color: highlight; }
#kkk input {
vertical-align:middle;
}
.MzTreeViewRow {border:none;width:100%;padding:0px;margin:0px;border-collapse:collapse}
.MzTreeViewCell0 {border-bottom:0px solid #CCCCCC;padding:0px;margin:0px;}
.MzTreeViewCell1 {border-bottom:1px solid #CCCCCC;border-left:1px solid #CCCCCC;width:200px;padding:0px;margin:0px;}

</style>
</head>

<body>
<table align="center" class='MzTreeViewRow' style="background:#EEEEEE;border-top:1px solid #CCCCCC;">
  <tr><td align="center" class='MzTreeViewCell0'>用户权限</td></tr>
</table>

<div id="kkk"></div>


<script language="javascript" type="text/javascript">
	<!--
	var MzTreeViewTH="<table class='MzTreeViewRow'><tr><td class='MzTreeViewCell0'>";
	var MzTreeViewTD="\"</td></tr></table>\"";
	
	window.tree = new MzTreeView("tree");
	/*
	tree.icons["property"] = "property.gif";
	tree.icons["css"] = "collection.gif";
	tree.icons["event"] = "collection.gif";
	tree.icons["book"]  = "book.gif";
	tree.iconsExpand["book"] = "bookopen.gif"; //展开时对应的图片
	*/
	tree.setIconPath("../images/"); //可用相对路径
	<?php
	$qx=$db -> get_one("select qx from g_user_group where groupid=".$groupid);
	
	$sql="select * from g_user_qx order by orderid";
	$query = $db -> query($sql);
	while($row = $db -> fetch_array($query)){
	?>
	tree.N["<?php echo $row['parentid'] ?>_<?php echo $row['classid'] ?>"] = "ctrl:sel;checked:<?php echo chkqx($qx,$row['classid']) ?>;T:<?php echo $row['classname'] ?>;url:"
	<?php
	}
	?>

	//tree.setURL("#");
	tree.wordLine = false;
	tree.setTarget("main");
	document.getElementById("kkk").innerHTML=tree.toString();
	tree.expandAll();
	
	//alert(document.getElementsByTagName("head")[0].innerHTML);
	//alert(document.getElementById("kkk").innerHTML);

	function showsel()
	{
		var es=document.getElementsByName("sel");
		var out="";
		for(var i=0;i<es.length;i++)
		{
			if (es[i].checked) out+=es[i].value+",";
		}
		//alert(out);
		out=out.substr(0,out.length-1);
		document.form1.qx.value=out;
		form1.submit();
	}
	//-->
	</script>
<form id="form1" name="form1" method="post" action="?action=edit&groupid=<?php echo $groupid ?>">
  <input type="hidden" name="qx" id="qx" value="<?php echo $qx ?>"/>
  <p align="center"><input type="button" onclick='showsel()' value=' 确定 ' /></p><br />
</form>

</body>
</html>
<?php
//检测权限id是否在权限组字符串中
function chkqx($str,$id){
    $flag=0;
    if($str){
		$arr=explode(',',$str);
		foreach($arr as $k=>$v){
		    if($v==$id){
			    $flag=1;
				break;
			}else{
			    $flag=0;
			}
		}
	}
	return $flag;
}
?>
