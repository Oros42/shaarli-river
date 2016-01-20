<!DOCTYPE html>
<html>
<head>
<title><?php echo HEAD_TITLE; ?></title>
<link href="./favicon.ico" rel="shortcut icon" type="image/x-icon" />
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<?php if(isset($header_rss)): ?>
<link rel="alternate" type="application/rss+xml" href="<?php echo $header_rss; ?>" title="RSS Feed" />
<?php endif; ?>
<link href="./assets/bootstrap.min.css" rel="stylesheet">
<?php
$theme_select=null;
if(!empty($_GET['t']) && (int)$_GET['t'] > 0){
	$theme_select=(int)$_GET['t'];
}elseif(!empty($_COOKIE["theme"]) && (int)$_COOKIE["theme"] >0 ){
	$theme_select=(int)$_COOKIE["theme"];
}
if(!empty($theme_select)){
	$themes = scandir('./themes/');
	unset($themes[0]);
	unset($themes[1]);
	if(isset($themes[$theme_select+1]) && substr($themes[$theme_select+1], -4)=='.css'){
		$theme='<link href="./themes/'.$themes[$theme_select+1].'" rel="stylesheet">';
		setcookie("theme", $theme_select);
	}
}
if(empty($theme)){
	if(defined('CSS_STYLE') && CSS_STYLE!= ''){
		$theme='<link href="./themes/'.CSS_STYLE.'" rel="stylesheet">';
	}else{
		$theme='<link href="./themes/style.css" rel="stylesheet">';
	}
}
echo $theme;
 ?>
</head>
<body>
<div id="page">
<div class="right"> &nbsp; <a id="play_stop" href="#" onclick="play_stop(); return false;" title="Stop" style="display:none">||</a></div>
<div id="error" class="right"></div>
<div id="timer"></div>
<h1><a href="./"><?php echo HEAD_TITLE; ?></a></h1>
