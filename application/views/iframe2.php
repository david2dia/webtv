<?= doctype('html5') ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" > 
	<head>
		<title><?= $infos[0]->nom ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=<?= $this->config->item('charset'); ?>" />
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" type="text/css" media="screen" href="<?= css_url('style'); ?>" />
		<link rel="stylesheet" type="text/css" media="screen" href="<?= css_url('bootstrap.min'); ?>" />
		<link rel="stylesheet" type="text/css" media="screen" href="<?= css_url('bootstrap-responsive.min'); ?>" />
		<!--[if lte IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>
<body>
<div <?php if ($infos[0]->activelogo=="f") echo 'class="hide"'; ?> id="logo"><?php if (empty($infos[0]->logo)) echo tagimg('chaines.png', 'logo'); else echo '<img src="'.$infos[0]->logo.'" alt="logo" width="162">'; ?>
</div>
	<div id="content">
		<!-- Slideshow HTML -->
			<div id="slideshow">
  				<div id="slidesContainer">

  				</div>
			</div>
		<!-- Slideshow HTML -->
	</div>
<dl <?php if ($infos[0]->activeband=="f") echo 'class="hide"'; ?> id="iTvScroller">
	<?php
		$datestring = "Nous somme le %d/%m/%Y - Il est %H:%i";
		$time = time();
	?>
    <?php if(sizeof($bandeaus)==1) echo "<dt>Date</dt><dd>".mdate($datestring, $time)."</dd>"; ?>
    <?php foreach($bandeaus as $bandeau): ?>
    	<dt><?= $bandeau->titremessage ?></dt>
    	<dd><?= $bandeau->message ?></dd>
	<?php endforeach; ?> 
</dl>

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="http://code.jquery.com/jquery.min.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
	<script>var page = <?= $pages ?></script>
	<script src="<?= js_url('jsconfig'); ?>"></script>
	<script src="<?= js_url('bandeau'); ?>"></script>
	<script type="text/javascript" >
$(function() {
    $('#iTvScroller').iTvScroller();
});
</script>
</body>
</html>