<!DOCTYPE html>
<html>
<head>
<title><?php echo HEAD_TITLE; ?></title>
<link href="./favicon.ico" rel="shortcut icon" type="image/x-icon" />
<meta charset="utf-8" />
<?php if(isset($header_rss)): ?>
<link rel="alternate" type="application/rss+xml" href="<?php echo $header_rss; ?>" title="RSS Feed" />
<?php endif; ?>
<link href="./assets/bootstrap.min.css" rel="stylesheet">
<?php if(defined('CSS_STYLE') && CSS_STYLE!= ''){
	echo '<link href="./assets/'.CSS_STYLE.'" rel="stylesheet">';
}else{
	echo '<link href="./assets/style.css" rel="stylesheet">';
} ?>
</head>
<body>
<div id="page">
<div class="right"> &nbsp; <a id="play_stop" href="#" onclick="play_stop(); return false;" title="Stop" style="display:none">||</a></div>
<div id="error" class="right"></div>
<div id="timer"></div>
<h1><a href="./"><?php echo HEAD_TITLE; ?></a></h1>