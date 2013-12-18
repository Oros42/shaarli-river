<?php 

require_once __DIR__ . '/bootstrap.php';

if( isset($_GET['json']) ) {

	$last_id = (isset($_GET['id']) && (int) $_GET['id'] > 0) ? (int) $_GET['id'] : 0;

	$api = new ShaarliApiClient( SHAARLI_API_URL );
	$rows = $api->latest();
	$rows = array_reverse($rows);

	$json = array();

	$json['id'] = 0;
	$json['entries'] = array();

	foreach( $rows as $row ) {

		if( $row->id > $last_id ) {

			$entry = array();

			$content = array();
			$content[] = '<div class="entry">';
			$content[] = '<div class="entry-timestamp">' . date('d/m/Y H:i:s', strtotime($row->date)) . '</div>';			
			$content[] = '<a class="entry-shaarli" target="_blank" href="' . @$row->feed->link . '">';
			$content[] = '<img class="favicon" src="' . get_favicon_url($row->feed->id)  .'" />' . $row->feed->title . '</a> ';
			$content[] = '<a class="entry-title" target="_blank" href="' . $row->permalink . '">' . $row->title . '</a>';
			$content[] = '<div class="entry-content">' . $row->content . '</div>';
			$content[] = '</div>';

			$entry['content'] = implode($content);
			unset($content);

			$json['entries'][] = $entry;
		}

		if( $row->id > $json['id'] ) { // Max id
			$json['id'] = $row->id;
		}
	}

	$json['count'] = count($json['entries']);

	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');
	echo json_encode($json);
	exit();
}

$header_rss = SHAARLI_API_URL . 'latest?format=rss';
include __DIR__ . '/includes/header.php';
?>

<div style="float:right;">
	<a class="btn btn-default" target="_blank" href="<?php echo SHAARLI_API_URL; ?>latest?pretty=1">JSON</a>
	<a class="btn btn-default" target="_blank" href="<?php echo SHAARLI_API_URL; ?>latest?format=rss">RSS</a>
</div>

<?php include __DIR__ . '/includes/menu.php'; ?>

<div id="entries"></div>
<script type="text/javascript">
document.getElementById('link-river').className+=' btn-primary';

var id = '';
var timer = 1000;

function river() {

	if( timer > 99 ) {
		timer=-timer;
		var xhr = new XMLHttpRequest();
		xhr.open('GET', 'index.php?json=1&id='+id);
		xhr.onreadystatechange = function(){
			if(xhr.readyState == 4){
				json = JSON.parse(xhr.responseText);
				if( json.count > 0 ) {
					if( timer == -1000 ) {
						for (var i = 0, len=json.count; i <len; i++) {
							document.getElementById('entries').insertAdjacentHTML('afterBegin', json.entries[i].content);
						};
					} else {
						for (var i = 0, len=json.count; i <len; i++) {
							var node = json.entries[i].content.replace('<div class="entry">', '<div class="entry unread" onmouseover="this.className=\'entry\';count_unread();">');
							/*
							// http://stackoverflow.com/questions/3795481/javascript-slidedown-without-jquery
		        			node.hover(function() {
		        				$(this).removeClass('unread');
		        				count_unread();
		        			});
		        			node.hide();
		        			*/
			        		document.getElementById('entries').insertAdjacentHTML('afterBegin', node);
			        		//node.slideDown();							
						};				
					}
					id = json.id;
					count_unread();
				}
				timer = 0;
			}
		};
		xhr.send();
		
	} else {
		if(timer>=0){
			timer++;
		}		
		if( timer < 0 ) {
			document.getElementById('timer').innerHTML = 'Checking...';
		} else {
			document.getElementById('timer').innerHTML = timer;
		}
	}
	setTimeout(river, 100);
}
function count_unread() {
	var title = "<?php echo HEAD_TITLE; ?>";
	var unread = document.getElementsByClassName('unread').length;
	if( unread > 0 ) {
		document.title='('+unread+') '+title;
	} else {
		document.title=title;
	}
}
river();
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>