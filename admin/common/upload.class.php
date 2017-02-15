<?php
/*
 * 文件名：upload.class.php
 * 功  能：文件上传类
 * 日  期：2010-9-14
 */

class UploadFile{
	
	public $max_size = 100000;    //允许上传文件的大小,设置为 -1 代表没有限制
	public $allow_types = 'jpg|gif|png|zip|rar|txt|html|bmp|pdf';    //允许上传文件的类型
	protected $file_type = array();    //文件类型
	public $sava_path = './uploads/';    //上传文件存放的目录
	public $file_name = 'date';    //文件名命名方式date time 都代表以当前时间命名 其他都代表使用愿文件名
	public $errmsg = '';    //错误信息

	public function __construct(){
		$this->setFileType();
	}

	public function upLoad($file){
		$name = $file['name']; //文件名
		$type = $file['type']; //获取文件类型
		$size = $file['size']; //获取上传文件大小
		$tmp_name = $file['tmp_name']; //临时文件地址文件名
		$error = $file['error']; //获得文件上传错误信息
		if($error == 0 ){ // Go If
			//如果错误代码为0代表没有错误
			if(is_uploaded_file($tmp_name)){ // Go IF
				//检测文件是否通过 http post 上传
				$allow_types = explode('|',$this->allow_types); //分割允许上传的文件类型
				$type = $this->getFileType($type); //获取上传文件的类型
				if(in_array($type,$allow_types)){
					//如果上传的文件类型在用户允许的类型中
					if($size < $this->max_size){
						 //如果上传文件大小不超过允许上传的大小
						 $this->setSavaPath(); //设置上传文件保存路径
						 if($this->file_name == 'date' || $this->file_name == 'time'){
							  //如果设置了文件名命名方式为时间或日期
						 	  $new_name = $this->sava_path . date('YmdHis',time()) . '.' . $type;
						 }else{
							  $new_name = $this->sava_path . $name;
						 }
						 if($this->move_file($tmp_name, $new_name)){
							$this->setErrMsg('');
							$file_info = array(
								'size'=>$size,
								'type'=>$type,
								'name'=>$new_name,
								'error'=>$error
							);
							return $file_info;
						 }else{
							$this->setErrMsg('文件移动失败！');
						 }

					}else{
						$this->setErrMsg('文件过大，最多可上传' . $this->max_size . 'k的文件！');
					}
				}else{
					//如果没在提示错误
					$this->setErrMsg('只支持上传' . $this->allow_types . '等文件类型！');
				}
			}else{ //Else
				//如果不是设置错误信息
				$this->setErrMsg('文件不是通过HTTP POST方式上传的！');
			} // End If is_uploaded_file
		} // End If	 error = 0
	}

	/**
	 * 移动文件
	 * @access public
	 * @param string - $tmp_name 原文件路径加文件名
	 * @param string - $new_name 新文件路径加文件名
	 * @return 返回文件是否移动成功
	 */
	public function move_file($tmp_name, $new_name){
		if(!file_exists($tmp_name)){
			$this->setErrMsg('需要移动的文件不存在');
		}
		if(file_exists($new_name)){
			$this->setErrMsg('文件' . $new_name . '已经存在！');
		}
		if(function_exists('move_uploaded_file')){
			$state =  move_uploaded_file($tmp_name, $new_name);
		}else if(function_exists('rename')){
			$state = rename($tmp_name, $new_name);
		}  
		return $state;
	}

	/**
	 * 设置文件上传后的保存路径
	 */
	protected function setSavaPath(){
		$this->sava_path = (preg_match('/\/$/',$this->sava_path)) ? $this->sava_path : $this->sava_path . '/';
		if(!is_dir($this->sava_path)){
			//如果目录不存在，创建目录
			$this->makeDir();
		}
	}
	

	/**
	 * 创建目录
	 * @access public
	 * @param  string - $dir 目录名
	 */
	public function makeDir($dir = null){
		if(!$dir){
			$dir = $this->sava_path;
		}
		if(is_dir($dir)){
			$this->setErrMsg('需要创建的文件夹已经存在！');
		}
		$dir = explode('/', $dir);
		foreach($dir as $v){
			if($v){
				$d .= $v . '/';
				if(!is_dir($d)){
					$state = mkdir($d, 0777);
					if(!$stete)
						$this->setErrMsg('在创建目录' . $d . '时出错！');
				}
			}
		}
		return true;
	}

	/**
	 * 设置错误信息
	 * $access protected
	 * $param string - $msg 错误信息字符串
	 */
	protected function setErrMsg($msg){
		$this->errmsg = $msg;
	}

	public function getFileType($type){
		foreach($this->file_type as $k=>$v){
			if($type == $v){
				return $k;
			}
		}
	}


	/**
	 * 设置常见的文件类型
	 * @access protected
	 */
	protected function setFileType(){
	    $this->file_type['chm']='application/octet-stream';
		$this->file_type['ppt']='application/vnd.ms-powerpoint';
		$this->file_type['xls']='application/vnd.ms-excel';
		$this->file_type['doc']='application/msword';
		$this->file_type['exe']='application/octet-stream';
		$this->file_type['rar']='application/octet-stream';
		$this->file_type['js']="javascript/js";
		$this->file_type['css']="text/css";
		$this->file_type['hqx']="application/mac-binhex40";
		$this->file_type['bin']="application/octet-stream";
		$this->file_type['oda']="application/oda";
		$this->file_type['pdf']="application/pdf";
		$this->file_type['ai']="application/postsrcipt";
		$this->file_type['eps']="application/postsrcipt";
		$this->file_type['es']="application/postsrcipt";
		$this->file_type['rtf']="application/rtf";
		$this->file_type['mif']="application/x-mif";
		$this->file_type['csh']="application/x-csh";
		$this->file_type['dvi']="application/x-dvi";
		$this->file_type['hdf']="application/x-hdf";
		$this->file_type['nc']="application/x-netcdf";
		$this->file_type['cdf']="application/x-netcdf";
		$this->file_type['latex']="application/x-latex";
		$this->file_type['ts']="application/x-troll-ts";
		$this->file_type['src']="application/x-wais-source";
		$this->file_type['zip']="application/zip";
		$this->file_type['bcpio']="application/x-bcpio";
		$this->file_type['cpio']="application/x-cpio";
		$this->file_type['gtar']="application/x-gtar";
		$this->file_type['shar']="application/x-shar";
		$this->file_type['sv4cpio']="application/x-sv4cpio";
		$this->file_type['sv4crc']="application/x-sv4crc";
		$this->file_type['tar']="application/x-tar";
		$this->file_type['ustar']="application/x-ustar";
		$this->file_type['man']="application/x-troff-man";
		$this->file_type['sh']="application/x-sh";
		$this->file_type['tcl']="application/x-tcl";
		$this->file_type['tex']="application/x-tex";
		$this->file_type['texi']="application/x-texinfo";
		$this->file_type['texinfo']="application/x-texinfo";
		$this->file_type['t']="application/x-troff";
		$this->file_type['tr']="application/x-troff";
		$this->file_type['roff']="application/x-troff";
		$this->file_type['shar']="application/x-shar";
		$this->file_type['me']="application/x-troll-me";
		$this->file_type['ts']="application/x-troll-ts";
		$this->file_type['gif']="image/gif";
		$this->file_type['jpeg']="image/pjpeg";
		$this->file_type['jpg']="image/pjpeg";
		$this->file_type['jpe']="image/pjpeg";
		$this->file_type['ras']="image/x-cmu-raster";
		$this->file_type['pbm']="image/x-portable-bitmap";
		$this->file_type['ppm']="image/x-portable-pixmap";
		$this->file_type['xbm']="image/x-xbitmap";
		$this->file_type['xwd']="image/x-xwindowdump";
		$this->file_type['ief']="image/ief";
		$this->file_type['tif']="image/tiff";
		$this->file_type['tiff']="image/tiff";
		$this->file_type['pnm']="image/x-portable-anymap";
		$this->file_type['pgm']="image/x-portable-graymap";
		$this->file_type['rgb']="image/x-rgb";
		$this->file_type['xpm']="image/x-xpixmap";
		$this->file_type['txt']="text/plain";
		$this->file_type['c']="text/plain";
		$this->file_type['cc']="text/plain";
		$this->file_type['h']="text/plain";
		$this->file_type['html']="text/html";
		$this->file_type['htm']="text/html";
		$this->file_type['htl']="text/html";
		$this->file_type['rtx']="text/richtext";
		$this->file_type['etx']="text/x-setext";
		$this->file_type['tsv']="text/tab-separated-values";
		$this->file_type['mpeg']="video/mpeg";
		$this->file_type['mpg']="video/mpeg";
		$this->file_type['mpe']="video/mpeg";
		$this->file_type['avi']="video/x-msvideo";
		$this->file_type['qt']="video/quicktime";
		$this->file_type['mov']="video/quicktime";
		$this->file_type['moov']="video/quicktime";
		$this->file_type['movie']="video/x-sgi-movie";
		$this->file_type['au']="audio/basic";
		$this->file_type['snd']="audio/basic";
		$this->file_type['wav']="audio/x-wav";
		$this->file_type['aif']="audio/x-aiff";
		$this->file_type['aiff']="audio/x-aiff";
		$this->file_type['aifc']="audio/x-aiff";
		$this->file_type['swf']="application/x-shockwave-flash";
	}
	
}
?>