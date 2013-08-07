<section class="row">
	<form class="span7" action="<?= site_url('superadmin/channel'); ?>" method="post">
		<fieldset>
			<legend>Add Channel</legend>
			<div class="controls controls-row">
				<input type="text" class="span3" name="nom" id="nom" TABINDEX="1" placeholder="Name" value="<?= set_value('nom'); ?>" required="required" aria-required="true" />
				<input type="text" class="span3" id="responsable" name="responsable" required="required" placeholder="Responsable In Charge" aria-required="true" data-provide="typeahead" autocomplete="off" data-source='[<?php $rows = count($responsables,0);$i=1;
				foreach($responsables as $responsable) {echo '"'.$responsable->responsable.'"';if($rows!=$i)echo",";$i++;} ?>]'>
			</div>
			<div class="controls controls-row">
				<input type="text" class="span3" name="description" id="description" TABINDEX="2" placeholder="Description" value="<?= set_value('description'); ?>" />
				<select id="groupe" class="span3" name="groupe" required="required" aria-required="true">
					<option value="">Choose Groupe of Channel</option>
					<?php foreach($groupes as $groupe): ?>
					<option value="<?= $groupe->idgroupe ?>"><?= $groupe->nom; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="controls">
				<input type="url" class="span6" id="urllogo" name="urllogo" placeholder="Url Logo">		
				<div class="help-block hide"></div>
			</div>
			<div class="span5">
			 <label class="checkbox inline pull-left"><input type="checkbox" id="activelogo" name="activelogo" value="on"> View logo of Channel</label>
			 <label class="checkbox inline pull-right"><input type="checkbox" id="activeband" name="activeband" value="on"> View Strip of Channel</label>
			</div>
		</fieldset>
		<input class="btn btn-large btn-success pull-right" type="submit" value="Add" />
	</form>
</section>