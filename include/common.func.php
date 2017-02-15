<?php
/*
 * 文件名：common.func.php
 * 功  能：系统公用函数库
 * 日  期：2015-08-10
 */

/* 防注入函数 */
if (!get_magic_quotes_gpc ()) {
	$_GET = sec ( $_GET );
	$_POST = sec ( $_POST );
	$_COOKIE = sec ( $_COOKIE );
	$_FILES = sec ( $_FILES );
}

function sec(&$array) { 
	//如果是数组，遍历数组，递归调用
	if (is_array ( $array )) {
		foreach ( $array as $k => $v ) {
		$array [$k] = sec ( $v );
		} 
	} else if (is_string ( $array )) {
	//使用addslashes函数来处理
	    $array = addslashes ( $array );	
		$array = stripSql( $array );
	} else if (is_numeric ( $array )) {
	    $array = intval ( $array );
	}
	return $array;
}

/**
 *  过滤SQL关键字函数
 */
function stripSql($str){
	$sqlkey = array(	 //SQL过滤关键字
	    "/\\\'/",
		'/\s*select\s*/i',
		'/\s*delete\s*/i',
		'/\s*update\s*/i',
		'/\s*drop\s*/i',
		'/\s*or\s*/i',
		'/\s*union\s*/i',
		'/\s*outfile\s*/i'
	);
	$replace = array(  //和上面数组内容对应
		'',
		'&nbspselect&nbsp;',
		'&nbsp;delete&nbsp;',
		'&nbsp;update&nbsp;',
		'&nbsp;drop&nbsp;',
		'&nbsp;or&nbsp;',
		'&nbsp;union&nbsp;',
		'&nbsp;outfile&nbsp;'
	);
	if(!is_array($str)){
		//如果不是数组直接替换
		$str = preg_replace($sqlkey,$replace,$str); 
		return $str;
	}else{
		//如果是数组
		$new_str = array();
		foreach($str as $k=>$v){
			//遍历整个数组进行替换
			$new_str[$k] = stripSql($v);
		}
		unset($sqlkey,$replace);
		return $new_str;
	}
}
 
/* 审核状态显示 */  
function chkstates($num) {
    if($num==0){$v='<font color=red>未审核</font>';}
	if($num==1){$v='<font color=blue>已审核</font>';}
	if($num==2){$v='<font color=green>已置顶</font>';}
	return $v;
}

/* 格式化时间 */ 
function formatdate($sj){
    if(!empty($sj)){
	   return @date('Y-m-d',strtotime($sj));
	}
}
 
/* 通用alert提示 */  
function htmlendjs($msg,$url='') {
	if($msg){
		echo "<script type=\"text/javascript\">alert('$msg');</script>";
	}
	switch($url){
		case '':
			echo "<script type=\"text/javascript\">history.back();</script>";
			exit();
			break;
		case 'close':
			echo "<script type=\"text/javascript\">window.close();</script>";
			exit();
			break;
		case 'open':
			echo "<script type=\"text/javascript\">if(self == top){ window.opener.location.reload();window.close();}else{window.location='".$_SERVER['HTTP_REFERER']."';}</script>";
			exit();
			break;
		case 'self':
			echo "<script type=\"text/javascript\">window.location='".$_SERVER['HTTP_REFERER']."';</script>";
			exit();
			break;	
		default:
			echo "<script type=\"text/javascript\">window.location='$url';</script>";
			exit();
	}
}

//$class_arr[] = array($row['classid'],$row['classname'],$row['parentid']);
//$m:填充长度 $parentid:父类ID $id:当前ID
function nclass_select($class_arr,$m=0,$parentid=0,$id=0) {	
	$n = str_pad('',$m,'-',STR_PAD_RIGHT);
	$n = str_replace("-","│",$n);
	for($i=0;$i<count($class_arr);$i++){
	
		if($class_arr[$i][2]==$parentid){
			if($class_arr[$i][0]==$id){
				$str.="        <option value=\"".$class_arr[$i][0]."\" selected=\"selected\">".$n."├ ".$class_arr[$i][1]."</option>\n";
			}else{
				$str.="        <option value=\"".$class_arr[$i][0]."\">".$n."├ ".$class_arr[$i][1]."</option>\n";
			}
			$str.=nclass_select($class_arr,$m+1,$class_arr[$i][0],$id);			
		}		
	}	
	return $str;
} 
 
/*搜索结果加亮 */ 
function replaceKey($key,$text){
	$keys = explode(' ', $key);
	foreach($keys as $v){
		if(preg_match('/'.$v.'/iSU', $text)){
			$text = str_replace($v, '<font color="#FF0000">'.$v.'</font>', $text);
		}
	}
	return $text;
}

/* 搜索获取纯文本 */
function html2text($str){
	$str = strip_tags($str);
	$str = str_replace('&nbsp', '', $str);
	$str = str_replace(' ','',$str);
	return $str;
}


/**
 * 将实体<br>转换为\n
 */
function htmldecode($str){
	$str = str_replace('<br />',"\n",$str);
	$str = str_replace('<br>',"\n",$str);
	$str = str_replace('&nbsp;'," ",$str);
	$str = str_replace('&lt','<',$str);
	$str = str_replace('&gt','>',$str);
	return $str;

}

/*
 * 转换HTML标签
 */
function htmlcode($str){
	if(!is_array($str)){
		$str = str_replace(' ', '&nbsp;', $str);
		$str = str_replace('<', '&lt', $str);
		$str = str_replace('>', '&gt', $str);
		$str = str_replace("\n", '<br />', $str);
		return $str;
	}else{
		foreach($str as $k=>$v){
			$new_str[$k] = stripHtml($v);
		}
		return $new_str;
	}
}

/**
 * 字符串截取
 */
function gottopic($String, $Length,$act = true) {
	//if (mb_strwidth($String, 'UTF8') <= $Length) {
      if (mb_strwidth($String) <= $Length) {
		return $String;
	} else {
		$I = 0;
		$len_word = 0;
		while ($len_word < $Length) {
			$StringTMP = substr($String, $I, 1);
			if (ord($StringTMP) >= 224) {
				$StringTMP = substr($String, $I, 3);
				$I = $I +3;
				$len_word = $len_word +2;
			}
			elseif (ord($StringTMP) >= 192) {
				$StringTMP = substr($String, $I, 2);
				$I = $I +2;
				$len_word = $len_word +2;
			} else {
				$I = $I +1;
				$len_word = $len_word +1;
			}
			$StringLast[] = $StringTMP;
		}
		/* raywang edit it for dirk for (es/index.php)*/
		if (is_array($StringLast) && !empty ($StringLast)) {
			$StringLast = implode("", $StringLast);
			if($act){
				$StringLast .= "...";
			}
		}
		return $StringLast;
	}
}

/**
 * 新闻列表显示
 */
function news_class($classid,$num=8,$len,$istime=1){
	global $db;	
	if($classid){
		$str='<ul class="list">';
		$sql="select top $num id,title,convert(varchar(20),addtime,111) as sj from article where states>0 and classid=$classid order by states desc,id desc";
		$rs = $db -> query($sql);
		while ($row=$db->fetch_array($rs)) {
			$str.='<li><a href="article.php?id='.$row['id'].'">'.gottopic($row['title'],$len).'</a>';
			if ($istime) {
				$str.='<span>['.$row['sj'].']</span>';
			}
			$str.='</li>';
		}
		$str.='</ul>';
		return $str;
	}
	else{
	return '';	
	}
}

//默认页面变量
$page = $_GET['page'];

//$totle：信息总数；
//$pagesize：每页显示信息数，这里设置为默认是20；
//$url：分页导航中的链接参数(除page)
function TurnPage($totle,$pagesize=20,$url='auto',$halfPer=5){
	
	global $page,$offset,$pagenav;	
	//$GLOBALS["pagesize"]=$pagesize;
	
	$totalpage=ceil($totle/$pagesize); //最后页，也是总页数
	//$page=min($totalpage,$page);
	if(!isset($page)||$page<1) $page=1;
	
	$prepage=$page-1; //上一页
	$nextpage=$page+1; //下一页
	$offset=($page-1)*$pagesize;//偏移量
	if($totalpage<=1) return false;
	
	//自动获取GET变量
	if($url=='auto'){
		foreach($_GET as $k=>$v){
			if($k!='page'){
				if($v!='') $str.=$k.'='.$v."&";
			} 
		}
		$url=$str;
	}
	
	//获取当前文件名
	$filename = end(explode('/',$_SERVER['PHP_SELF']));   
	
	//开始分页导航条代码：
	$pagenav="显示第 <B>".max($offset+1,1)."</B>-<B>".min($offset+$pagesize,$totle)."</B> 条记录，共 $totle 条记录";
	
	$pagenav.=" <a href=$filename?$url"."page=1>首页</a> ";
	if($prepage>0) $pagenav.=" <a href=$filename?$url"."page=$prepage>上页</a> "; 
	
	for ( $i = $page - $halfPer,$i > 0 || $i = 1 , $j = $page + $halfPer, $j <= $totalpage || $j = $totalpage;$i <= $j ;$i++ )
	{
		$pagenav .= $i == $page 
			? " <span class='current'>$i</span>" 
			: " <a href=$filename?$url"."page=$i>$i</a>";
	}
	
	if($nextpage<$totalpage) $pagenav.=" <a href=$filename?$url"."page=$nextpage>下页</a> "; 
	$pagenav.=" <a href=$filename?$url"."page=$totalpage>尾页</a> ";
	
	//下拉跳转列表，循环列出所有页码：
	$pagenav.="　到第 <select name='topage' size='1' onchange='window.location=\"$filename?$url"."page=\"+this.value'>\n";
	for($i=1;$i<=$totalpage;$i++){
	  if($i==$page){
		  $pagenav.="<option value='$i' selected>$i</option>\n";}
	  else{
		  $pagenav.="<option value='$i'>$i</option>\n"; 
	   } 
	}
	$pagenav.="</select> 页，共 $totalpage 页";
}

/**
 * 建立请求，以表单HTML形式构造（默认）
 * @param $para 请求参数数组
 * @param $method 提交方式。两个值可选：post、get
 * @return 提交表单HTML文本
 */
function buildRequestForm($action,$para,$method) {		
	$sHtml = "<form id='autosubmit' name='autosubmit' action='".$action."' method='".$method."'>";
	while (list ($key, $val) = each ($para)) {
		$sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
	}
	$sHtml = $sHtml."</form>";
	
	$sHtml = $sHtml."<script>document.forms['autosubmit'].submit();</script>";
	return $sHtml;	
}

function file_get_contents_post($url, $post) {  
    $options = array(  
        'http' => array(  
            'method' => 'POST',  
            // 'content' => 'name=gongjun&email=hmgj940@sohu.com',  
            'content' => http_build_query($post),  
        ),  
    ); 
    $result = file_get_contents($url, false, stream_context_create($options));  
    return $result;  
} 
?>