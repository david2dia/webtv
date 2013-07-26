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
		<a href="<?= site_url('admin/voir_chaine/'.$numChaines); ?>" class="btn btn-large btn-danger btn-block">Retour</a>
		<?php endif; endif; ?>
	</div>
</div>