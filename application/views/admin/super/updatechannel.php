<section class="row">
	<form class="span7" action="<?= site_url('superadmin/updateChannelBDD'); ?>" method="post">
		<fieldset>
			<legend>Update Channel <small><?= $channel[0]->nom ?></small></legend>
			<div class="controls controls-row">
				<input type="text" class="span3" name="nom" id="nom" TABINDEX="1" placeholder="Name" value="<?= $channel[0]->nom ?>" required="required" aria-required="true" />
				<input type="text" class="span3" id="responsable" name="responsable" required="required" placeholder="Responsable In Charge" value="<?= $channel[0]->responsable ?>" aria-required="true" data-provide="typeahead" autocomplete="off" data-source='[<?php $rows = count($responsables,0);$i=1;
				foreach($responsables as $responsable) {echo '"'.$responsable->responsable.'"';if($rows!=$i)echo",";$i++;} ?>]'>
			</div>
			<div class="controls controls-row">
				<input type="text" class="span3" name="description" id="description" TABINDEX="2" placeholder="Description" value="<?= $channel[0]->description ?>" />
				<select id="groupe" class="span3" name="groupe" required="required" aria-required="true">
					<option value="">Choose Groupe of Channel</option>
					<?php foreach($groupes as $groupe): ?>
					<option value="<?= $groupe->idgroupe ?>" <?php if($groupe->idgroupe==$channel[0]->idgroupe) echo "selected='selected'" ?>><?= $groupe->nom; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="controls">
				<input type="url" class="span6" id="urllogo" name="urllogo" placeholder="Url Logo" value="<?= $channel[0]->logo ?>">		
				<div class="help-block hide"></div>
			</div>
			<div class="span5">
			<label class="checkbox pull-left"><input type="checkbox" id="activelogo" name="activelogo" value="on" <?php if($channel[0]->activelogo=="t") echo "checked='checked'" ?>> View logo of Channel</label>
			 <label class="checkbox inline pull-right"><input type="checkbox" id="activeband" name="activeband" value="on" <?php if($channel[0]->activeband=="t") echo "checked='checked'" ?>> View Strip of Channel</label>
			</div>
			
		</fieldset>
		<input type="hidden" id="idchaine" name="idchaine" value="<?= $channel[0]->idchaine ?>">	
		<input class="btn btn-large btn-success pull-right" type="submit" value="Update" />
	</form>
</section>
