<?php
class action extends db {

	/**
	 * 用户权限判断
	 */
	public function Get_user_check() {
		if (!$_SESSION['userid'] && !$_SESSION['groupid']) {
		     echo "<script>top.location.href='/gocms/admin/login.php';</script>";
			 exit();
		}
	} 
	//========================================

	/**
	 * 用户登陆
	 */
	public function Get_user_login($username, $password) {
		$username = str_replace(" ", "", $username);
		$query = $this->query("select * from g_user where username='$username'");
               	$flag = is_array($row = $this->fetch_array($query))? md5($password) == $row[password] : FALSE;
		
                
               if ($flag) {
			$_SESSION['userid'] = $row['userid'];
			$_SESSION['groupid'] = $row['groupid'];
              
			$this->query('update g_user set lastlogintime=now() where userid='.$_SESSION['userid']);
			htmlendjs('登陆成功！','main.php');
		} else {
			htmlendjs('用户名或密码错误！','');
			session_destroy();
		}
	}
	 /**
	  * 用户退出登陆
	  */
	public function Get_user_out() {
		session_destroy();
		echo "<script>top.location.href='login.php';</script>";
	}

	//========================
} //end class
?>