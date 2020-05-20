<?php 

require_once __DIR__ . '/bootstrap.php';

$searchCategory = isset($_GET['c']) && $_GET['c'] == 1;

if( isset($_GET['q']) && !empty($_GET['q']) ) {

	// Sanitize input
	// Source: http://ulyssesonline.com/2011/10/19/sanitize-your-input-in-php
	function sanitize($in) {
		return addslashes(htmlspecialchars(strip_tags(trim($in))));
	}

	$searchterm = sanitize($_GET['q']);

	$api = new ShaarliApiClient( SHAARLI_API_URL );
	if ($searchCategory) {
		$entries = $api->search( $searchterm, array('c'=>'1') );
	} else {
		$entries = $api->search( $searchterm );
	}
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
  <div class="form-group col-sm-6">
    <div class="input-group">
        <input type="text" class="form-control" name="q" value="<?php if(isset($searchterm)) echo $searchterm; ?>" id="input-search" placeholder="search"/>
      	<label class="input-group-addon" for="search-category" id="search-category" >
	  		<input type="checkbox" name="c" value="1"<?php echo $searchCategory?' checked="checked"':''; ?>> tag?
        </label>
    </div>
  </div>
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