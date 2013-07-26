<?php $this->load->helper('text');  ?>
<!-- Masthead
================================================== -->
<header class="jumbotron masthead gradient span5" id="overview">
  <div class="container">
    <h1>WebTV</h1>
    <p class="lead">Choose your Channel</p>
    <a class="btn" href="<?= site_url('admin') ?>"><i class="icon-cog"></i> Administration</a>
  </div>
</header>
<div class="span6 text-right hide">
<?= tagimg('logo-ITPI.png', 'logo', '200px', '200px') ?>
<p class="alert alert-success text-left hide"><strong>Date : </strong><?php $datestring = "%d/%m/%Y <strong>Hour : </strong>%H:%i";$time = time();
echo mdate($datestring, $time); ?><br / ><strong>Numbers of channels : </strong><?= $nbchaine ?> <p>
</div>
<div class="span12">
	<div class="mt35">
		<a href="#"><i class="icon-th-list"></i></a>
		<a href="#"><i class="icon-th-large"></i></a>
		<a href="#"><i class="icon-th"></i></a>
	</div>
	<div id="liste" class="mt35 hide">
		<?php if (!empty($chaines)): ?>
		<table id="affliste" class="table table-striped container tablesorter">
			<tr>
				<th>Channel</th>
				<th>Reponsable</th>
				<th>Description</th>
			</tr>

		<?php foreach($chaines as $chaine): ?>
			<tr>
				<td><a data-rel="tooltip" data-original-title="Show Channel" class="tooltipb" href="<?= site_url('affichage/voir_chaine/'.$chaine->idchaine); ?>"><?= $chaine->nom; ?></a></td>
				<td>
					<?= $chaine->responsable; ?>
				</td>
				<td><?= word_limiter($chaine->description,20); ?>...</td>
			</tr>
		<?php endforeach; ?>
			</tr>
		</table>
	<?php else: ?>No channel in this group.<?php endif; ?>
	</div>
	<div id="icone" class="row mt35">
		<?php foreach($chaines as $chaine): ?>
			<div class="span3 mt35 text-center vr" id="chaine_<?= $chaine->idchaine ?>">
				<a href="<?= site_url('affichage/voir_chaine/'.$chaine->idchaine); ?>">
					<?php if (empty($chaine->logo)) echo tagimg('chaines.png', 'logo'); else echo '<img src="'.$chaine->logo.'" alt="logo">'; ?><br /><?= $chaine->nom; ?>
				</a>
			</div>
		<?php endforeach; ?>
		<?php if (isset($groupes)): foreach($groupes as $groupe): ?>
			<div class="span3 mt35 text-center vr" id="chaine_<?= $groupe->idgroupe ?>">
				<a href="<?= site_url('welcome/liste/'.$groupe->idgroupe); ?>">
					<?php if (empty($groupe->logo)) echo tagimg('multiChaines.png', 'logo'); else echo '<img src="'.$groupe->logo.'" alt="logo">'; ?><br /><?= $groupe->nom; ?>
				</a>
			</div>
		<?php endforeach; endif; ?>
	</div>
	<div id="icone2" class="row mt35 hide">
		<?php foreach($chaines as $chaine): ?>
			<div class="span2 mt35 text-center" id="chaine_<?= $chaine->idchaine ?>">
				<a href="<?= site_url('affichage/voir_chaine/'.$chaine->idchaine); ?>">
					<?php if (empty($chaine->logo)) echo tagimg('chaines.png', 'logo'); else echo '<img src="'.$chaine->logo.'" alt="logo">'; ?><br /><?= $chaine->nom; ?>
				</a>
			</div>
		<?php endforeach; ?>
		<?php if (isset($groupes)): foreach($groupes as $groupe): ?>
			<div class="span2 mt35 text-center vr" id="chaine_<?= $groupe->idgroupe ?>">
				<a href="<?= site_url('welcome/liste/'.$groupe->idgroupe); ?>">
					<?php if (empty($groupe->logo)) echo tagimg('multiChaines.png', 'logo'); else echo '<img src="'.$groupe->logo.'" alt="logo">'; ?><br /><?= $groupe->nom; ?>
				</a>
			</div>
		<?php endforeach; endif; ?>
	</div>
</div>