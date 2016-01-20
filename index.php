<?php 

require_once __DIR__ . '/bootstrap.php';

if( isset($_GET['json']) ) {
	$last_id = (isset($_GET['id']) && (int) $_GET['id'] > 0) ? (int) $_GET['id'] : 0;

	$api = new ShaarliApiClient( SHAARLI_API_URL );
	try{
		$rows = $api->latest();
	}catch(Exception $e){
        	header('Cache-Control: no-cache, must-revalidate');
	        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        	header('Content-type: application/json');
	        echo "Networking error :-(";
	        exit();
	}
	$json = array();

	$json['id'] = 0;
	$json['entries'] = array();

	if ($rows != null){
		$rows = array_reverse($rows);
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
var play=1;
function mark_as_read(e){
	e.className='entry';
	e.onmouseover = '';
	count_unread();
}

function slideDown (element) {
	element.className = 'entry unread';
	var s = element.style;
	element.hidden=false;
	var finalheight=element.clientHeight;
	s.height = '0px';   
	var y = 0;
	var tween = function () {
		y += 10;
		s.height = y+'px';
		if(window.scrollY>0){
			window.scroll(0,window.scrollY+10);
		}
		if (y<finalheight) {
			setTimeout(tween,50);
		}
	}
	tween();
}
function river() {
	if(play>0){
		if( timer > 99 ) {
			timer=-timer;
			var xhr = new XMLHttpRequest();
			xhr.open('GET', 'index.php?json=1&id='+id);
			xhr.onreadystatechange = function(){
				if(xhr.readyState == 4){
					try{
						json = JSON.parse(xhr.responseText);
						if( json.count > 0 ) {
							if( timer == -1000 ) {
								for (var i = 0, len=json.count; i <len; i++) {
									document.getElementById('entries').insertAdjacentHTML('afterBegin', json.entries[i].content);
								};
							} else {
								for (var i = 0, len=json.count; i <len; i++) {
									var node = new DOMParser().parseFromString(json.entries[i].content, 'text/html');
									for (var e = 0, len2=node.children[0].children[1].children.length; e <len2; e++) {
										node.children[0].children[1].children[e].className += ' unread hide';
										node.children[0].children[1].children[e].style.overflow= 'hidden';
										node.children[0].children[1].children[e].hidden=true;
										node.children[0].children[1].children[e].setAttribute('onmouseover', 'mark_as_read(this);');
									}
									document.getElementById('entries').insertAdjacentHTML('afterBegin', node.children[0].children[1].innerHTML);
								};
								for(var i=0, len=document.getElementsByClassName('unread hide').length; i<len; i++){
									slideDown(document.getElementsByClassName('unread')[i]);
								}
							}
							id = json.id;
							count_unread();
						}
						document.getElementById('error').innerHTML = '';
					}catch(e){
						document.getElementById('error').innerHTML = '&nbsp; Network error ! ';
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
function play_stop(){
	if(play){
		document.getElementById('play_stop').innerHTML="▶";
		document.getElementById('play_stop').title="Play";
		play=0;
	}else{
		document.getElementById('play_stop').innerHTML="||";
		document.getElementById('play_stop').title="Stop";
		play=1;
		timer = 100;
		river();
	}	
}
document.getElementById('play_stop').style.display="";
river();
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>
