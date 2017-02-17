<?php
require('../global.php');
//参数
$id=(int)$_GET['id'];
$action=$_POST['action'];
$classid=(int)$_POST["classid"];
$cpname=trim($_POST["cpname"]);
$imgurl=trim($_POST["imgurl"]);
$source=trim($_POST["source"]);
$content=$_POST["content"];
$keyword=trim($_POST["keyword"]);
$hits=(int)$_POST["hits"];
$states=(int)$_POST["states"];
$addtime=$_POST["addtime"];
//初始化
$act='add';
function init(){
global $cpname,$imgurl,$source,$content,$keyword,$addtime;
if(empty($cpname)){ htmlendjs("产品名称不能为空",""); }
if(empty($content)){ htmlendjs("产品内容不能为空",""); }
if(empty($addtime)){ $addtime=date('Y-m-d H:i:s'); }
}
//操作
if($action=='add'){
    init();
    $db->query("INSERT INTO g_cp(classid,cpname,imgurl,source,content,keyword,hits,states,addtime) VALUES($classid,'$cpname','$imgurl','$source','$content','$keyword',$hits,$states,'$addtime')");	
    htmlendjs('添加成功','cp_add.php');
}
if($action=='edit'){
    init();
    $db->query("update g_cp set classid=$classid,cpname='$cpname',imgurl='$imgurl',source='$source',content='$content',keyword='$keyword',hits=$hits,states=$states,addtime='$addtime' where id=$id");	
    htmlendjs('修改成功','open');
}
//赋值
if(!empty($id)){
    $rs=$db->query("select * from g_cp where id=$id");
    $row = $db -> fetch_array($rs);
    if($row){
    $classid=$row['classid'];
$cpname=$row['cpname'];
$imgurl=$row['imgurl'];
$source=$row['source'];
$content=$row['content'];
$keyword=$row['keyword'];
$hits=$row['hits'];
$states=$row['states'];
$addtime=$row['addtime'];
    $act='edit';
    }
    
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE>后台管理</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<link rel="stylesheet" href="../../editor/themes/default/default.css" />
<LINK href="../css/style.css" type=text/css rel=stylesheet>
<script type="text/javascript" src="../../include/validator.js"></script>
<script type="text/javascript" src="../../include/common.js"></script>
<script charset="utf-8" src="../../editor/kindeditor.js"></script>
<script charset="utf-8" src="../../editor/lang/zh_CN.js"></script>
<script type="text/javascript">
var editor;
KindEditor.ready(function(K) {
	editor = K.create('textarea[name="content"]', {
		allowFileManager : true
	});
	K('input[name=insertNext]').click(function(e) {
		editor.insertHtml('[NextPage]');
	});
});
</script>
</HEAD>
<BODY>
<BR>
<form action="?id=<?php echo $id; ?>" method="post" onSubmit="return Validator.Validate(this,3)">
	<table width="800" border=0 align=center cellpadding="0" cellspacing=1 bgcolor="#D9F1BA" >
<tr>
		<th height="25" colspan="3" background="../images/tab_14.gif">添加产品</th>
	</tr>
	
    <tr>
   <td width=89 height="30" align="center" bgcolor="#F6FEEB">产品名称</td>
  <td height="30" bgcolor="#FFFFFF"><input type="text" name="cpname" size=50 datatype="Require" msg="产品名称不能为空" id="cpname" value="<?php echo $cpname; ?>"/></td>
  <td width="367" rowspan="4" align="center" bgcolor="#FFFFFF"><img src="../images/no_pic.gif" id="img" onload="DrawImage(this,160,120)" onclick="window.open(this.src)" style="cursor:hand"/>
    <input type="hidden" name="imgurl" id="imgurl" value="<?php echo $imgurl; ?>"/>
    <iframe frameborder="0" scrolling="no" src="../common/up.php?path=../../uploadfile/images" width="100%" height="25"></iframe></td>
    </tr>
   <tr>
   <td width=89 height="30" align="center" bgcolor="#F6FEEB">产品分类</td>
  <td height="30" bgcolor="#FFFFFF">
    <select name="classid" datatype="Require" msg="请选择类别">
    <option value="">- 请选择类别 -</option>
    <?php
		$class_arr=array();
		$sql = "select * from g_nclass_cp order by orderid";
		$query = $db -> query($sql);
		while($row = $db -> fetch_array($query)){
			$class_arr[] = array($row['classid'],$row['classname'],$row['parentid'],$row['orderid']);
		}
		echo nclass_select($class_arr,0,0,$classid);
    ?>
  </select></td>
    </tr>
       <tr>
   <td width=89 height="30" align="center" bgcolor="#F6FEEB">厂家/品牌</td>
  <td width="340" height="30" bgcolor="#FFFFFF"><input type="text" name="source" id="source" value="<?php echo $source; ?>"/></td>
    </tr>
       <tr>
         <td height="30" align="center" bgcolor="#F6FEEB">关键字</td>
         <td height="30" bgcolor="#FFFFFF"><input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>"/></td>
       </tr>
       <tr>
   <td height="30" colspan="3" align="center" bgcolor="#F6FEEB">
     <textarea name="content" style="width:98%;height:280px;"><?php echo $content; ?></textarea>   </td>
  </tr>
    <tr>
   <td height="50" colspan="3" align="center" bgcolor="#F6FEEB">
     <input type="submit" class="btn"  value=" 提交 ">
     <input type="hidden" name="action" id="action" value="<?php echo $act; ?>"/></td>
  </tr>
    
	</table> 
</form>
<p>&nbsp;</p>
</BODY></HTML>
