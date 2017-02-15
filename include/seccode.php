<?PHP
error_reporting(7);
session_start();
session_register('code');
$_SESSION['code'] = "";
$width            = "42";//图片宽
$height           = "22";//图片高
$len              = "4";//生成几位验证码
$bgcolor          = "#d6e3ef";//背景色
$noise            = true;//生成杂点
$noisenum         = 40;//杂点数量
$border           = true;//边框
$bordercolor      = "#000000";
$image            = imageCreate($width, $height);
$back             = getcolor($bgcolor);

imageFilledRectangle($image, 0, 0, $width, $height, $back);
$size = $width / $len;
if ($size > $height) {
	$size=$height;
}
$left = ($width - $len * ($size + $size / 10)) / $size;

$textall = array_merge_recursive(range('0','9'));
for ($i=0; $i<$len; $i++) {
    $tmptext=rand(0, 9);
	$randtext = $textall[$tmptext];
    $code .= $randtext;
}

$textColor = imageColorAllocate($image, 0, 0, 0);
imagestring($image, $size, 3, 3, $code, $textColor); 

if($noise) {
	setnoise();
}

$_SESSION['code'] = $code;
$bordercolor = getcolor($bordercolor); 
if($border) {
	imageRectangle($image, 0, 0, $width-1, $height-1, $bordercolor);
}

header("Content-type: image/png");
imagePng($image);
imagedestroy($image);

function getcolor($color) {
	global $image;
	$color = eregi_replace ("^#","",$color);
	$r = $color[0].$color[1];
	$r = hexdec ($r);
	$b = $color[2].$color[3];
	$b = hexdec ($b);
	$g = $color[4].$color[5];
	$g = hexdec ($g);
	$color = imagecolorallocate ($image, $r, $b, $g); 
	return $color;
}

function setnoise() {
	global $image, $width, $height, $back, $noisenum;
	for ($i=0; $i<$noisenum; $i++){
		$randColor = imageColorAllocate($image, rand(0, 255), rand(0, 255), rand(0, 255));  
		imageSetPixel($image, rand(0, $width), rand(0, $height), $randColor);
	} 
}
?>