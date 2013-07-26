<section class="row">
	<form class="span7" action="<?= site_url('superadmin/updateGroupeBDD'); ?>" method="post">
		<fieldset>
			<legend>Update Group <small><?= $groupe[0]->nom ?></small></legend>
			<div class="controls controls-row">
				<input type="text" class="span3" name="nom" id="nom" TABINDEX="1" placeholder="Name" value="<?= $groupe[0]->nom ?>" required="required" aria-required="true" />
				<select id="groupe" class="span3" name="groupe" required="required" aria-required="true">
					<option value="NULL">None</option>
					<?php foreach($parents as $parent): ?>
					<option value="<?= $parent->idgroupe ?>" <?php if($parent->idgroupe==$groupe[0]->parent) echo "selected='selected'" ?>><?= $parent->nom; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="controls">
				<input type="text" class="span6" name="description" id="description" TABINDEX="2" placeholder="Description" value="<?= $groupe[0]->description ?>" />
			</div>
			<div class="controls">
				<input type="url" class="span6" id="urllogo" name="urllogo" placeholder="Url Logo" value="<?= $groupe[0]->logo ?>">		
				<div class="help-block hide"></div>
			</div>
		</fieldset>
		<input type="hidden" id="idgroupe" name="idgroupe" value="<?= $groupe[0]->idgroupe ?>">	
		<input class="btn btn-large btn-success pull-right" type="submit" value="Update" />
	</form>
</section>