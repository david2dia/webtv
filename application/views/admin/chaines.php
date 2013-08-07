<div class="span12 hide <?= isset($numChaines) ? 'hide' : ''; ?> offset1 text-center">
	<div id="icone" class="row mt35">
		<?php foreach($chaines as $chaine): ?>
			<div class="span3 mt35 text-center vr" id="chaine_<?= $chaine->idchaine ?>">
				<a href="<?= site_url('admin/voir_chaine/1/'.$chaine->idchaine); ?>">
					<?php if (empty($chaine->logo)) echo tagimg('chaines.png', 'logo'); else echo '<img src="'.$chaine->logo.'" alt="logo">'; ?><br /><?= $chaine->nom; ?>
				</a>
			</div>
		<?php endforeach; ?>
		<?php if (isset($groupes)): foreach($groupes as $groupe): ?>
			<div class="span3 mt35 text-center vr" id="chaine_<?= $groupe->idgroupe ?>">
				<a href="<?= site_url('admin/voir_chaine/'.$groupe->idgroupe); ?>">
					<?php if (empty($groupe->logo)) echo tagimg('multiChaines.png', 'logo'); else echo '<img src="'.$groupe->logo.'" alt="logo">'; ?><br /><?= $groupe->nom; ?>
				</a>
			</div>
		<?php endforeach; endif; ?>
	</div>
</div>
<div class="row-fluid">
	<div class="<?= isset($numChaines) ? 'span3' : 'span9'; ?> offset1 text-center">
		<div id="image"><?= tagimg('retro-tv.png', 'retro-tv', 150, 132); ?></div>
		<form method="post" action="<?= site_url('admin/voir_chaine'); ?>">
			<label for="num_chaines" class="hide">Chaine :</label>
			<select id="num_chaines" name="num_chaines" data-placeholder="Choose your channel..." class="chzn-select" onchange='this.form.submit()'>
				<option value="false">Choose your channel</option>
				<?php foreach($chaines as $chaine): ?>
				<option value="<?= $chaine->idchaine; ?>" <?php if(isset($numChaines) && $chaine->idchaine==$numChaines) echo 'selected="selected"' ?>><?= $chaine->nom; ?></option>
			<?php endforeach; ?>
		</select>
		</form>
		<?php if(!isset($numChaines)): ?>
			<a class="btn btn-large mt35" href="<?= site_url('admin/ajoutMultiple') ?>"><?= tagimg('multiChaines.png', 'Multi channel', '14px', '14px') ?> Add page for MultiChannel</a>
		<?php endif; ?>
	</div>
	<div class="span3 offset3 text-center">
		<?php if(isset($numChaines)): ?>
		<a href="<?= site_url('affichage/voir_chaine/'.$numChaines); ?>" class="btn btn-large btn-success btn-block">View channel</a><br />
		<?php if (!isset($edition)): ?>
		<a href="<?= site_url('admin/edition/'.$numChaines); ?>" class="btn btn-large btn-danger btn-block">More options</a>
		<?php else: ?>
		<a href="<?= site_url('admin/voir_chaine/0/'.$numChaines); ?>" class="btn btn-large btn-danger btn-block">Retour</a>
		<?php endif; endif; ?>
	</div>
</div>