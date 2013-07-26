<div class="row">
	<a href="<?= site_url('admin/voir_chaine/'); ?>" class="btn pull-left btn-large btn-danger">Retour</a>
	<div class="span9">
		<div id="image" class="text-center"><?= tagimg('retro-tv.png', 'retro-tv', 150, 132); ?></div>
		<?php if(isset($confirmation)) echo $confirmation ?>
		<form class="form-horizontal" id="add" action="<?= site_url('admin/ajoutMultiple') ?>" method="post" novalidate>
			<div class="control-group text-center">
					<select id="groupe" name="groupe" data-placeholder="Choose your Group..." class="chzn-select">
						<option value="false">Choose your Group</option>
						<?php foreach($groupes as $groupe): ?>
						<option value="<?= $groupe->idgroupe; ?>"><?= $groupe->nom; ?></option>
						<?php endforeach; ?>
				</select>
			</div>
			<div class="control-group">
				<label class="control-label" for="titre" accesskey="T">Titre :</label>
				<div class="controls">
					<input type="text" class="input-xxlarge" name="titre" id="titre" TABINDEX="1" placeholder="Enter Title of Page" value="<?= set_value('titre'); ?>" required="required" />
					<?= form_error('titre'); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="url">URL :</label>
				<div class="controls">
					<input type="url" class="input-xxlarge" name="url" id="url" TABINDEX="2" placeholder="Enter website address" value="<?= set_value('url'); ?>" required="required" />
					<?= form_error('url'); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="temps">Length (en s) :</label>
				<div class="controls">
					<input type="number" class="input-xxlarge" name="temps" id="temps" TABINDEX="3" value="<?= set_value('temps'); ?>" />
					<?= form_error('temps'); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" class="control-label" for="date_debut">From :</label>
				<div class="controls">
					<input type="date" class="input-xxlarge" name="date_debut" id="date_debut" TABINDEX="4" min="<?= mdate("%Y-%m-%d", time()); ?>" placeholder="<?= mdate("%Y-%m-%d", time()); ?>" value="<?= set_value('date_debut'); ?>" />
					<?= form_error('date_debut'); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="date_fin">To :</label>
				<div class="controls">
					<input type="date" class="input-xxlarge" name="date_fin" id="date_fin" TABINDEX="5" min="<?= mdate("%Y-%m-%d", time()); ?>" placeholder="<?= mdate("%Y-%m-%d", strtotime('+1 years')); ?>" value="<?= set_value('date_fin'); ?>" />
					<?= form_error('date_fin'); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="time_debut">Starts at :</label>
				<div class="controls">
					<input type="time" class="input-xxlarge" name="time_debut" id="time_debut" TABINDEX="6" placeholder="07:00" value="<?= set_value('time_debut'); ?>" />
					<?= form_error('time_debut'); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="time_fin">Ends at :</label>
				<div class="controls">
					<input type="time" class="input-xxlarge" name="time_fin" id="time_fin" TABINDEX="7" placeholder="19:00" value="<?= set_value('time_fin'); ?>" />
					<?= form_error('time_fin'); ?>
				</div>
			</div>
			<div class="control-group hide">
				<label class="control-label" for="hebdo1">Hebdomadaire :</label>
				<div class="controls">
					<label class="checkbox inline"><input type="checkbox" id="hebdo[]" value="1"> Lundi</label>
					<label class="checkbox inline"><input type="checkbox" id="hebdo[]" value="2"> Mardi</label>
					<label class="checkbox inline"><input type="checkbox" id="hebdo[]" value="3"> Mecredi</label>
					<label class="checkbox inline"><input type="checkbox" id="hebdo[]" value="4"> Jeudi</label><br />
					<label class="checkbox inline"><input type="checkbox" id="hebdo[]" value="5"> Vendredi</label>
					<label class="checkbox inline"><input type="checkbox" id="hebdo[]" value="6"> Samedi</label>
					<label class="checkbox inline"><input type="checkbox" id="hebdo[]" value="7"> Dimanche</label>
				</div>
			</div>
			<div class="control-group hide">
				<label class="control-label" for="public">Page Publique :</label>
				<div class="controls">
					<input type="checkbox" name="public" id="public" TABINDEX="9" />
					<?= form_error('public'); ?>
				</div>
			</div>
			<input type="submit" name="post" class="btn btn-primary pull-right" value="Add Page" />
		</form>
	</div>
</div>