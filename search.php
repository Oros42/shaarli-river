<?php 

require_once __DIR__ . '/bootstrap.php';

if( isset($_GET['q']) && !empty($_GET['q']) ) {

	// Sanitize input
	// Source: http://ulyssesonline.com/2011/10/19/sanitize-your-input-in-php
	function sanitize($in) {
		return addslashes(htmlspecialchars(strip_tags(trim($in))));
	}

	$searchterm = sanitize($_GET['q']);

	$api = new ShaarliApiClient( SHAARLI_API_URL );
	$entries = $api->search( $searchterm );
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/menu.php';

?>

<?php if( isset($entries) ): ?>
<div style="float:right;">
	<a class="btn btn-default" target="_blank" href="<?php echo SHAARLI_API_URL_PUBLIC; ?>search?pretty=1&q=<?php echo $searchterm; ?>">JSON</a>
	<a class="btn btn-default" target="_blank" href="<?php echo SHAARLI_API_URL_PUBLIC; ?>search?q=<?php echo $searchterm; ?>&format=rss">RSS</a>
</div>
<?php endif; ?>

<form class="form-inline" role="form">
  <input id="input-search" class="form-control" name="q" value="<?php if(isset($searchterm)) echo $searchterm; ?>" style="width:60%;"/>
  <button type="submit" class="btn btn-success">Ok</button>
</form>
<br />

<?php if( isset($entries) ): ?>
<?php if( !empty($entries) ): ?>
<div id="entries">
<?php

foreach( $entries as $entry ) {

	include __DIR__ . '/includes/entry.php';
}

?>
</div>
<?php else: ?>
<div>
	No result.
</div>
<?php endif; ?>
<?php endif; ?>

<script type="text/javascript">
document.getElementById('link-search').className+=' btn-primary';
document.getElementById('input-search').focus();
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>