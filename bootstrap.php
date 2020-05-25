<?php

$configFile = __DIR__.'/config.php';

if( !file_exists('config.php') )
	exit('Please setup your config.php');

require_once __DIR__ . '/includes/ShaarliApiClient.php';
require_once $configFile;

function get_favicon_url( $feed_id ) {
	$feed_id = (int) $feed_id;
	if( $feed_id > 0 ) {
		$faviconName = sprintf("favicons/fav_%d.png", $feed_id);
		$faviconNameDir = __DIR__.'/'.$faviconName;
		if (!is_file($faviconNameDir) || (time() - filectime($faviconNameDir) > 630000) ) { //630000s == 7day of cache
			$favicon = @file_get_contents(sprintf('%sgetfavicon?id=%d', SHAARLI_API_URL, $feed_id));
			if (!empty($favicon)) {
				file_put_contents($faviconNameDir, $favicon);
			}
		}
		return $faviconName;
	}
}

function makeCategoryLink($c) {
	$categories = explode(',', $c);
	foreach ($categories as $key => $value) {
		$tag = trim($value);
		$categories[$key] = sprintf(
			'<a href="search.php?c=1&q=%s">%s</a>',
			$tag,
			$tag
		);
	}
	return implode(', ', $categories);
}