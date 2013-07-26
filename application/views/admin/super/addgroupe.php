<section class="row">
	<form class="span7" action="<?= site_url('superadmin/groupe'); ?>" method="post">
		<fieldset>
			<legend>Add Group</legend>
			<div class="controls controls-row">
				<input type="text" class="span3" name="nom" id="nom" TABINDEX="1" placeholder="Name" value="<?= set_value('nom'); ?>" required="required" aria-required="true" />
				<select id="groupe" class="span3" name="groupe" required="required" aria-required="true">
					<option value="">Choose Group Parents</option>
					<option value="NULL">None</option>
					<?php foreach($groupes as $groupe): ?>
					<option value="<?= $groupe->idgroupe ?>"><?= $groupe->nom; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="controls">
				<input type="text" class="span6" name="description" id="description" TABINDEX="2" placeholder="Description" value="<?= set_value('description'); ?>" />
			</div>
			<div class="controls">
				<input type="url" class="span6" id="urllogo" name="urllogo" placeholder="Url Logo">		
				<div class="help-block hide"></div>
			</div>
		</fieldset>
		<input class="btn btn-large btn-success pull-right" type="submit" value="Add" />
	</form>
</section>