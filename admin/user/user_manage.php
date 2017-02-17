<?php
require('../global.php');

$action=$_GET['action'];
$key=$_GET['key'];
$groupid=$_GET['groupid'];

if($action=='chk'){
	$db->query("update g_user set states=$_GET[st] where userid=$_GET[userid]");
	htmlendjs("操作成功","open");
}
if($action=='del'){
	$db->query("DELETE FROM g_user WHERE userid =$_GET[userid] LIMIT 1");
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
        <td width="115" background="../images/tab_05.gif"><img src="../images/tb.gif" width="16" height="16" /><span class="title">用户</span></td>
        <td align="right" background="../images/tab_05.gif"><form id="form1" name="form1" method="get" action="">
          <input type="text" name="key" id="key" />
          <select name="groupid">
            <option value="">- 不限类别 -</option>
            <?php
                $sql = "select * from g_user_group order by orderid";
                $query = $db -> query($sql);
                while($row = $db -> fetch_array($query)){
                    echo "<option value='$row[groupid]'>$row[groupname]</option>";
                }
            ?>
          </select>
           <input type="submit" value="查询" />&nbsp;&nbsp;
           <img src="../images/add.gif" width="14" height="14" />&nbsp;<a href="javascript:void(0);" onclick="newwin('user_add.php',420,210);">新增用户</a>
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
            <td width="8%" height="26" align="center" background="../images/tab_14.gif" class="STYLE1">ID</td>
            <td width="22%" height="26" align="center" background="../images/tab_14.gif" class="STYLE1">用户名</td>
            <td width="20%" height="26" align="center" background="../images/tab_14.gif" class="STYLE1">用户组</td>
            <td width="18%" height="26" align="center" background="../images/tab_14.gif" class="STYLE1">最后一次登录时间</td>
            <td width="12%" align="center" background="../images/tab_14.gif" class="STYLE1">当前状态</td>
            <td width="20%" height="26" align="center" background="../images/tab_14.gif" class="STYLE1">操作</td>
            </tr>
          	<?php
            
			$sql="select * from g_user where userid>0";
			$sql.=($key)?" and username like '%$key%'":"";
			$sql.=($groupid)?" and groupid=$groupid":"";
				
			$total = $db->num_rows($db->query($sql));
			
			TurnPage($total, $pagesize,"&key=$key&groupid=$groupid");
			$sql.=" order by userid desc limit $offset,$pagesize";
			//echo $sql;exit();
			
			$query = $db->query($sql);
			while ($row = $db->fetch_array($query)) { 
			?>
          <tr bgcolor="#FFFFFF" onMouseMove="this.style.backgroundColor='#F0F8FF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">
            <td height="22" align="center"><?php echo $row['userid'] ?></td>
            <td height="22" align="center"><a href="javascript:void(0);" onclick="newwin('user_info.php?userid=<?php echo $row['userid'] ?>',400,240);"><?php echo $row['username']?></a></td>
            <td height="22" align="center"><?php echo $db->get_one('select groupname from g_user_group where groupid='.$row['groupid']) ?></td>
            <td height="22" align="center"><?php echo $row['lastlogintime']?></td>
            <td align="center"><?php echo chkstates($row['states']) ?></td>
            <td height="22" align="center">
            <img src="../images/write.gif" width="9" height="9" />[<a href="javascript:void(0);" onclick="newwin('user_edit.php?userid=<?php echo $row['userid'] ?>',420,210);">编辑</a>]
            <img src="../images/del.gif" width="9" height="9" /> [<a href="javascript:void(0);" onClick="return confirm('删除《<?php echo $row['username'] ?>》，是否确定？')?newwin('?action=del&userid=<?php echo $row['userid']?>',1,1):false">删除</a>]
            <select name="states" onchange="newwin('?action=chk&userid=<?php echo $row['userid']?>&states='+this.options[selectedIndex].value,1,1);">
              <option selected>-审核-</option>
              <option value="1">已审核</option>
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
