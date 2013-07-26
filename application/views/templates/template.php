<?= doctype('html5') ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" > 
	<head>
		<title><?= $title ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=<?= $this->config->item('charset'); ?>" />
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" type="text/css" media="screen" href="<?= css_url('style'); ?>" />
		<link rel="stylesheet" type="text/css" media="screen" href="<?= css_url('datepicker'); ?>" />
		<link rel="stylesheet" type="text/css" media="screen" href="<?= css_url('chosen'); ?>" />
		<!--[if lte IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]--> 
	</head>
	  	<body>
		<!-- Header Menu  -->
			<nav id="nav" class="navbar navbar-inverse navbar-static-top" role="banner">
				<div class="navbar-inner">
					<div class="container">
						<ul class="nav">
							<li><a class="brand" href="<?= site_url() ?>">WebTV</a></li>
							<?php if (isset($nav_list) && $nav_list!=''): ?>
								<?php foreach($nav_list as $i => $nav_item): ?>	
									<li class="<?= ($nav == $nav_item ? 'active' : '')?>">
										<?= anchor(uri_string().'/'.$nav_item, $nav_item, 'title="'.$nav_item.'"') ?>
									</li>
								<?php endforeach ?>
							<?php endif; ?>
					</div>
	   			</div>
			</nav>
			<!-- contents  -->
			<div id="contents" class="container">
				
				<?= $contents ?>
				
			</div>
			<div style="clearfix"></div>
			<!-- footer  -->
			<footer id="footer" class="well hidden-phone">
				<div class="container">
					<p class="muted">
						Powered by IT Pole Interactif - In case of problems with WebTV, please contact Mohamed Rakza (
						<?= safe_mailto('mohamed.rakza@oxylane.com','mohamed.rakza@oxylane.com'); ?>)
					</p>
					<a href="https://sites.google.com/a/oxylane.com/webtv/" target="_blank"><?= tagimg('qrcode.png', 'Qr Code', '100', '100') ?></a>

				</div>
				<blockquote class="pull-right mt35">
  					<p>Ensemble, créer l'envie et rendre accessibles à chacun le plaisir et les bienfaits du sport.</p>
  					<small>Sportivement votre <cite title="Source Title">Oxylane</cite></small>
				</blockquote>
			</footer>

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="http://code.jquery.com/jquery.min.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<!-- 	<script src="<?= js_url('jquery-1.7.2.min'); ?>"></script> -->
	<script src="<?= js_url('chosen.jquery.min'); ?>"></script>
	<script src="<?= js_url('bootstrap.min'); ?>"></script>
	<script src="<?= js_url('bootstrap-datepicker'); ?>"></script>
	<script src="http://tablesorter.com/__jquery.tablesorter.min.js"></script>

	<!-- Scripts specific to this page -->
	<!-- Validate Plugin -->
	<script src="<?= js_url('jqBootstrapValidation'); ?>"></script>
	<script>var urlajax = '<?= site_url('admin/saveOrder'); ?>';</script>
	<script src="<?= js_url('script'); ?>"></script>
</body>
</html>