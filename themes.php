<?php 
require_once __DIR__ . '/bootstrap.php';
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/menu.php';
?>
<h3>Themes</h3>
<div>
<?php
	$files = scandir('./themes/');
	unset($files[0]);
	unset($files[1]);
	if(!empty($files)){
		$num_them=1;
		foreach ($files as $file) {
			if(substr($file, -4)=='.css'){
				echo "<div class='entry-link'>";
				if($theme_select==$num_them){
					echo "<span class='glyphicon glyphicon-arrow-right'> ";
				}
				echo "<a href='?t=$num_them'>$file</a></div>";
			}
			$num_them++;
		}
	}
?>
</div>
<script type="text/javascript">
document.getElementById('link-themes').className+=' btn-primary';
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>