<?= $this->load->view("admin/chaines"); ?>
<?= $this->load->view("admin/postit"); ?>
<?= $this->load->view("admin/liste_chaine"); ?>
	<form class="form-horizontal" action="<?= site_url('admin/ajout') ?>" method="post" novalidate>
		<div>
			<fieldset>
				<legend><?= $infos[0]->nom ?><small> ( <?= $infos[0]->groupe ?> )</small></legend>
				<?php if(isset($confirmation)) echo $confirmation ?>
				<div class="control-group">
					<label class="control-label" for="titre" accesskey="T"><abbr data-rel="tooltip" data-original-title="Required" class="tooltipb">*</abbr>Title :</label>
					<div class="controls">
						<input type="text" name="titre" id="titre" TABINDEX="1" placeholder="Enter Title of Page" value="<?= set_value('titre'); ?>" required="required" />
						<?= form_error('titre'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="url"><abbr data-rel="tooltip" data-original-title="Required" class="tooltipb">*</abbr>URL :</label>
					<div class="controls">
						<input type="url" name="url" id="url" TABINDEX="2" placeholder="Enter website address" value="<?= set_value('url'); ?>" required="required" />
						<?= form_error('url'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="temps">Length (en s) :</label>
					<div class="controls">
						<input type="number" name="temps" id="temps" TABINDEX="3" value="<?= set_value('temps'); ?>" />
						<?= form_error('temps'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" class="control-label" for="date_debut">From :</label>
					<div class="controls">
						<input type="date" data-date="<?= mdate("%Y-%m-%d", time()); ?>" data-date-format="yyyy-mm-dd" name="date_debut" id="date_debut" TABINDEX="4" class="datep" min="<?= mdate("%Y-%m-%d", time()); ?>" placeholder="<?= mdate("%Y-%m-%d", time()); ?>" value="<?= set_value('date_debut'); ?>" />
						<?= form_error('date_debut'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="date_fin">To :</label>
					<div class="controls">
						<input type="date" data-date="<?= mdate("%Y-%m-%d", time()); ?>" data-date-format="yyyy-mm-dd" name="date_fin" id="date_fin" TABINDEX="5" class="datep" min="<?= mdate("%Y-%m-%d", time()); ?>" placeholder="<?= mdate("%Y-%m-%d", strtotime('+1 years')); ?>" value="<?= set_value('date_fin'); ?>" />
						<?= form_error('date_fin'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="time_debut">Starts at :</label>
					<div class="controls">
						<input type="time" name="time_debut" id="time_debut" TABINDEX="6" placeholder="00:01" value="<?= set_value('time_debut'); ?>" />
						<?= form_error('time_debut'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="time_fin">Ends at :</label>
					<div class="controls">
						<input type="time" name="time_fin" id="time_fin" TABINDEX="7" placeholder="23:59" value="<?= set_value('time_fin'); ?>" />
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
			</fieldset>
			<input type="hidden" name="chaine" id="chaine" value="<?= $numChaines ?>" />
			<input type="submit" class="btn" value="Add Page" />
		</div>
	</form>
