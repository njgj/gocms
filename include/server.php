<?php
echo '$_SERVER["QUERY_STRING"]:<b>'.$_SERVER["QUERY_STRING"].'</b> 获取的是?后面的值,不包括?<br><br>';
//说明：查询(query)的字符串

echo '$_SERVER["REQUEST_URI"]:<b>'.$_SERVER["REQUEST_URI"].'</b> 获取http://...xxx/后面的值，包括/<br><br>';
//说明：访问此页面所需的URI

echo '$_SERVER["SCRIPT_NAME"]:<b>'.$_SERVER["SCRIPT_NAME"].'</b> 获取当前脚本的路径<br><br>';
//说明：包含当前脚本的路径

echo '$_SERVER["PHP_SELF"]:<b>'.$_SERVER["PHP_SELF"].'</b> 获取当前正在执行脚本的文件名<br><br>';
//说明：当前正在执行脚本的文件名

echo '__FILE__:<b> '.__FILE__.'</b> <br><br>' ;
echo 'dirname(__FILE__):<b>'.dirname(__FILE__).'</b><br><br>' ;
echo 'basename(__FILE__):<b>'.basename(__FILE__).'</b> <br><br>' ;
echo 'realpath(__FILE__):<b>'.realpath(__FILE__).'</b> <br><br>' ;


echo 'parse_url($_SERVER["REQUEST_URI"]):<br><br>';
//var_dump(parse_url($_SERVER["REQUEST_URI"]));

echo '$_SERVER[PHP_SELF]:<b>'.$_SERVER['PHP_SELF'].'</b> <br><br>';  
?>