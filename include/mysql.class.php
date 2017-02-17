<?php
/*
2015-07-14 '增加对mssql数据库支持' 
code by gongjun
*/
class db {
	var $version = '';
	var $querynum = 0;
	var $link = null;
	var $charset = 'utf-8';//gbk/utf-8
	var $dbtype='mysql';//mysql/sqlsrv
	
	function connect($dbhost, $dbuser, $dbpw, $dbname = '', $pconnect = 0) {
		if($this->dbtype=='mysql'){
			$func = empty($pconnect) ? 'mysql_connect' : 'mysql_pconnect';
			if(!$this->link = @$func($dbhost, $dbuser, $dbpw, 1)) {
			    $this->halt('Can not connect to MySQL server');
		    } else {
				mysql_query("SET NAMES ".str_replace('-','',$this->dbtype), $this->link);
				mysql_select_db($dbname, $this->link);
			}
		}
		
		if($this->dbtype=='sqlsrv'){
			$options =  array("UID"=>$dbuser,"PWD"=>$dbpw,"Database"=>$dbname);
			if(!$this->link = sqlsrv_connect($dbhost, $options)) {
			    $this->halt('Can not connect to MsSQL server');
		    }
		}
	}

	function select_db($dbname) {
		return mysql_select_db($dbname);
	}

	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		$func=$this->dbtype.'_fetch_array';
		$result_type=($this->dbtype=='sqlsrv')?SQLSRV_FETCH_ASSOC:MYSQL_ASSOC;
		return $func($query, $result_type);
	}

	function query($sql, $params=array(),$options=array( "Scrollable" => SQLSRV_CURSOR_KEYSET )) {
		if($this->dbtype=='mysql'){
			if(!($query = mysql_query($sql))) {
				$this->halt('Mysql Query Error', $sql);
			}
		}
		if($this->dbtype=='sqlsrv'){
			if(!($query = sqlsrv_query( $this->link, $sql,$params,$options))) {
				$this->halt('Mssql Query Error', $sql);
			}
		}
		$this->querynum++;
		return $query;
	}
	

	/**
	* 执行sql语句，只得到一条记录
	* @param string sql语句
	*/
	function get_one($sql) {
		return $this->result($this->query($sql), 0);
	}

	function affected_rows() {
		$func=$this->dbtype.'_affected_rows';
		return $func($this->link);
	}

	function error() {
		if($this->dbtype=='mysql'){
		return (($this->link) ? mysql_error($this->link) : mysql_error());
		}
		if($this->dbtype=='sqlsrv'){
		return sqlsrv_errors();
		}
	}

	function errno() {
		return intval(($this->link) ? mysql_errno($this->link) : mysql_errno());
	}

    /**
	* @return array
	*/
	function result($query, $row) {
		if($this->dbtype=='mysql'){
		$query = @mysql_result($query, $row);
		return $query;
		}
		if($this->dbtype=='sqlsrv'){			
		$query = sqlsrv_fetch_array($query, SQLSRV_FETCH_NUMERIC);
		return $query[$row];
		}
	}

	/**
	* 取得结果集中行的数目
	* @return int
	*/
	function num_rows($query) {
		$func=$this->dbtype.'_num_rows';
		$query = $func($query);
		return $query;
	}
	
	/**
	* 返回结果集中字段的数目
	* @return int
	*/
	function num_fields($query) {
		$func=$this->dbtype.'_num_fields';
		return $func($query);
	}
	
	//释放资源
	function free_result($query) {
		if($this->dbtype=='mysql'){
		return mysql_free_result($query);
		}
		if($this->dbtype=='sqlsrv'){
		return sqlsrv_free_stmt($query);
		}
	}
	
	/**
	* 取得上一步 INSERT 操作产生的 ID 
	* @return int
	*/
	function insert_id() {
		if($this->dbtype=='mysql'){
	    //return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
		//mysql_insert_id() expects parameter 1 to be resource?
		return ($id = mysql_insert_id()) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
		}
		if($this->dbtype=='sqlsrv'){
		return $this->result($this->query("SELECT @@IDENTITY"), 0);
		}
	}

    /**
	* @return array
	*/
	function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}

	function fetch_fields($query) {
		return mysql_fetch_field($query);
	}

    /**
	* @return string
	*/
	function version() {
		$func=($this->dbtype=='mysql')?'mysql_get_server_info':'sqlsrv_server_info';
		if(empty($this->version)) {
			$this->version = $func($this->link);
		}
		return $this->version;
	}
	
	function close() {
		$func=$this->dbtype.'_close';
		return $func();
	}

	function halt($message,$sql=''){
		$message = "<html>\n<head>\n";
		$message .= "<meta content=\"text/html; charset=$this->charset\" http-equiv=\"Content-Type\">\n";
		$message .= "<STYLE TYPE=\"text/css\">\n";
		$message .=  "body,td,p,pre {\n";
		$message .=  "font-family : Verdana, sans-serif;font-size : 11px;\n";
		$message .=  "}\n";
		$message .=  "</STYLE>\n";
		$message .= "</head>\n";
		$message .= "<body bgcolor=\"#FFFFFF\" text=\"#000000\" link=\"#006699\" vlink=\"#5493B4\">\n";
		$message .= "数据库出错: ".htmlspecialchars($msg)."\n<p>";
		$message .= "<b>$this->dbtype error description</b>: ".print_r($this->error(),true)."\n<br>";
		if($this->dbtype=='mysql'){
		$message .= "<b>$this->dbtype error number</b>: ".$this->errno()."\n<br>";
		}
		$message .= "<b>Date</b>: ".date("Y-m-d @ H:i",time())."\n<br>";
		$message .= "<b>Query</b>: ".$sql."\n<br>";
		$message .= "<b>Script</b>: http://".$_SERVER['HTTP_HOST'].getenv("REQUEST_URI")."\n<br>";
		$message .= "</body>\n</html>";
		die($message);
		exit;
	}

}
 
/* 获得当前classid的上级父id */  
function getParentId($tablename,$classid) {
	global $db;
	$v=false;
	if(!empty($classid)){
		 $v=$db->get_one("select parentid from $tablename where classid=$classid");
	}
	return $v;
}

/* 获得当前id下的子id组含本身 */  
function getClassPath($tablename,$classid) {
	global $db;
	static $v;
	$r=false;
    if(!empty($classid)){
	     $sql="select classid from $tablename where parentid=$classid order by orderid";
	     $rs = $db->query($sql);
	     while ($row = $db->fetch_array($rs)) {
	     	$v .= $row['classid'].',';
	     	getClassPath($tablename,$row['classid']);
	     }
		 $r=$classid.','.$v;
	     $r=substr($r,0,strlen($r)-1); 
	}
	return $r;
}


/* 获得当前classid的类别名称 */  
function getClassName($tablename,$classid) {
	global $db;
	$v=false;
	if(!empty($classid)){	
		 $v=$db->get_one("select classname from $tablename where classid=$classid");
	}
	return $v;
}	

/* 获得用户名 */  
function getUserName($userid) {
    global $db;
	$str='';
	if(!empty($userid)){	
		 $str=$db->get_one("select username from g_user where userid=$userid");
	}
	return $str;
}
?>