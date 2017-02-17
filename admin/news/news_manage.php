<?php
require('../global.php');

//管理
$action=$_GET['action'];
$id=(int)$_GET['id'];
$states=(int)$_GET['states'];
$classid=(int)$_GET['classid'];
$key=trim($_GET['key']);

if($action=='chk'){
	$db->query("update g_news set states=$states where id=$id");
	htmlendjs("操作成功","open");
}
if($action=='del'){	
	$db->query("DELETE FROM g_news WHERE id =$id LIMIT 1");
	htmlendjs("删除成功","open");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE>后台管理</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="../css/style.css" type=text/css rel=stylesheet>
<script type="text/javascript" src="../../include/common.js"></script>
</HEAD>
<BODY>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="15" height="30"><img src="../images/tab_03.gif" width="15" height="30" /></td>
        <td width="115" background="../images/tab_05.gif"><img src="../images/tb.gif" width="16" height="16" /><span class="title">新闻管理</span></td>
        <td align="right" background="../images/tab_05.gif"><form id="form1" name="form1" method="get" action="">
          <input type="text" name="key" id="key" />
          <select name="classid">
            <option value="">- 不限类别 -</option>
            <?php
                $class_arr=array();
                $sql = "select * from g_nclass order by orderid";
                $query = $db -> query($sql);
                while($row = $db -> fetch_array($query)){
                    $class_arr[] = array($row['classid'],$row['classname'],$row['parentid'],$row['orderid']);
                }
                echo nclass_select($class_arr,0,0);
            ?>
          </select>
           <input type="submit" value="查询" />
        </form>
        </td>
        <td width="14"><img src="../images/tab_07.gif" width="14" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="9" background="../images/tab_12.gif">&nbsp;</td>
        <td bgcolor="e5f1d6"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#D9F1BA">
          <tr>
            <td width="6%" height="26" align="center" background="../images/tab_14.gif" class="STYLE1">ID</td>
            <td width="30%" height="26" align="center" background="../images/tab_14.gif" class="STYLE1">标题</td>
            <td width="11%" height="26" align="center" background="../images/tab_14.gif" class="STYLE1">类别</td>
            <td width="11%" height="26" align="center" background="../images/tab_14.gif" class="STYLE1">作者</td>
            <td width="14%" height="26" align="center" background="../images/tab_14.gif" class="STYLE1">时间</td>
            <td width="10%" align="center" background="../images/tab_14.gif" class="STYLE1">当前状态</td>
            <td width="18%" height="26" align="center" background="../images/tab_14.gif" class="STYLE1">操作</td>
            </tr>
          	<?php
            
			$sql="select * from g_news where id>0";
			$sql.=($key)?" and title like '%$key%'":"";
			$sql.=($classid)?" and classid in (".getClassPath('g_nclass',$classid).")":"";
				
			$total = $db->num_rows($db->query($sql));
			
			TurnPage($total, $pagesize);
			$sql.=" order by id desc limit $offset,$pagesize";
			//echo $sql;exit();
			
			$query = $db->query($sql);
			while ($row = $db->fetch_array($query)) { 
			?>
          <tr bgcolor="#FFFFFF" onMouseMove="this.style.backgroundColor='#F6FEEB'" onMouseOut="this.style.backgroundColor='#FFFFFF'">
            <td height="22" align="center"><?php echo $row['id'] ?></td>
            <td height="22"><a href="../../news_show.php?id=<?php echo $row[id]?>" target="_blank"><?php echo $row['title']?></a></td>
            <td height="22" align="center"><?php echo getclassname('g_nclass',$row['classid']) ?></td>
            <td height="22" align="center"><?php echo $row['author']?></td>
            <td height="22" align="center"><?php echo formatdate($row['addtime']); ?></td>
            <td align="center"><?php echo chkstates($row['states']) ?></td>
            <td height="22" align="center">
            <img src="../images/write.gif" width="9" height="9" />[<a href="javascript:;" onclick="newwin('news_add.php?id=<?php echo $row['id']?>',800,500);">编辑</a>]
            <img src="../images/del.gif" width="9" height="9" /> [<a href="javascript:void(0);" onClick="return confirm('删除《<?php echo $row['title'] ?>》，是否确定？')?newwin('?action=del&id=<?php echo $row['id']?>',1,1):false">删除</a>]
            <select name="states" onchange="newwin('?action=chk&id=<?php echo $row['id']?>&states='+this.options[selectedIndex].value,1,1);">
              <option selected>-审核-</option>
              <option value="1">已审核</option>
              <option value="2">已置顶</option>
              <option value="0">未审核</option>
            </select>            </td>
            </tr>
          	<?php } ?>
        </table></td>
        <td width="9" background="../images/tab_16.gif">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="29"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="15" height="29"><img src="../images/tab_20.gif" width="15" height="29" /></td>
        <td align="center" background="../images/tab_21.gif"><?php echo $pagenav;?>&nbsp;</td>
        <td width="14"><img src="../images/tab_22.gif" width="14" height="29" /></td>
      </tr>
    </table></td>
  </tr>
</table>
</BODY>
</HTML>