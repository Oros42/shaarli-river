<?php 
require_once __DIR__ . '/bootstrap.php';
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/menu.php';
?>
<div class="entry">
        <h2>Accès via Tor</h2>
	<a href="https://ecirtamno7a6cynx.onion/shaarlirss/">https://ecirtamno7a6cynx.onion/shaarlirss/</a>
</div>

<div class="entry">
	<h2 id="xmpp">Salon de discussions</h2>
	<ul>
		<li>Matrix <a href="https://matrix.to/#/#shaarli:feneas.org">https://matrix.to/#/#shaarli:feneas.org</a></li>
		<li><a href="http://orangina-rouge.org/zbin/?c56d6624235e2ce9#NsQWefj/qUDmaQZe+BM9RwMG0oPnp9hZ5nTYFIzQR5g=">Plus d'infos</a> [old]</li>
	</ul>
</div>

<div class="entry">
	<h2>Contact</h2>
	<ul>
		<li>Pour l'ajout ou le retrait d'un shaarli, contactez Oros</li>
		<li>via shaarlirss[@]ecirtam.net</li>
	</ul>
</div>

<div class="entry">
	<h2>Projets autour de shaarli</h2>
	<ul>
		<li><a href="https://github.com/shaarli">Shaarli (github)</a></li>
		<li><a href="https://github.com/Oros42/shaarli-api">Shaarli-api (github)</a></li>
		<li><a href="https://github.com/Oros42/shaarli-river">Shaarli-river (github)</a></li>
		<li><a href="https://github.com/Oros42/find_shaarlis">Où sont les shaarlis ?</a></li>
		<li><a href="https://www.shaarlo.fr/">www.shaarlo.fr</a></li>
	</ul>
	<h2>Autres Shaarli-river</h2>
	<ul>
		<li><a href="https://river.libox.fr/">https://river.libox.fr/</a></li>
		<li><a href="http://petitetremalfaisant.eu/styx/">http://petitetremalfaisant.eu/styx/</a></li>

	</ul>
</div>
<div class="entry">
	<h2>Shaarli API</h2>
	Code source <a href="https://github.com/Oros42/shaarli-api">https://github.com/Oros42/shaarli-api</a><br>
	URLs :<br>
	<ul>
		<li><a href="https://ecirtam.net/shaarli-api/">https://ecirtam.net/shaarli-api/</a>
		<li><a href="https://shaarli-api.ecirtam.net/">https://shaarli-api.ecirtam.net/</a>
		<li><a href="https://ecirtamno7a6cynx.onion/shaarli-api/">https://ecirtamno7a6cynx.onion/shaarli-api/</a>
	</ul>
	<h3>Récupérer le backup d'un shaarli</h3>
	<code>&lt;URL_API&gt;/feed?id=&lt;ID&gt;&format=html&full=1</code><br>
	Exemple :<br>
	https://ecirtam.net/shaarli-api/feed?id=151&format=html&full=1<br>
</div>

<script type="text/javascript">
document.getElementById('link-infos').className+=' btn-primary';
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
