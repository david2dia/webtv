<form class="form-horizontal" method="post" novalidate>
	<fieldset>
		<legend>Update - <?= $page[0]->titre ?></legend>
			<div class="control-group">
				<label class="control-label" for="titre" accesskey="T">Title :</label>
				<div class="controls">
					<input type="text" name="titre" id="titre" TABINDEX="1" placeholder="Enter Title of Page" value="<?= $page[0]->titre ?>" required="required" />
					<?= form_error('titre'); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="url">URL :</label>
				<div class="controls">
					<input type="url" name="url" id="url" TABINDEX="2" placeholder="Enter website address" value="<?= $page[0]->url ?>" required="required" />
					<?= form_error('url'); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="temps">Length (en s) :</label>
				<div class="controls">
					<input type="number" name="temps" id="temps" TABINDEX="3" value="<?= $page[0]->temps ?>" />
					<?= form_error('temps'); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" class="control-label" for="date_debut">From :</label>
				<div class="controls">
					<input type="date" data-date="<?= mdate("%Y-%m-%d", time()); ?>" data-date-format="yyyy-mm-dd" name="date_debut" id="date_debut" TABINDEX="4" min="<?= mdate("%Y-%m-%d", time()); ?>" placeholder="<?= mdate("%Y-%m-%d", time()); ?>" value="<?= $page[0]->datedebut ?>" />
					<?= form_error('date_debut'); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="date_fin">To :</label>
				<div class="controls">
					<input type="date" data-date="<?= mdate("%Y-%m-%d", time()); ?>" data-date-format="yyyy-mm-dd" name="date_fin" id="date_fin" TABINDEX="5" min="<?= mdate("%Y-%m-%d", time()); ?>" placeholder="<?= mdate("%Y-%m-%d", strtotime('+1 years')); ?>" value="<?= $page[0]->datefin ?>" />
					<?= form_error('date_fin'); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="time_debut">Starts at :</label>
					<div class="controls">
						<input type="time" name="time_debut" id="time_debut" TABINDEX="6" placeholder="<?= $page[0]->timedebut ?>" value="<?= $page[0]->timedebut ?>" class="input-small">
						<?= form_error('temps_debut'); ?>
					</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="time_fin">Ends at :</label>
					<div class="controls">
			            <input type="time"  name="time_fin" id="time_fin" TABINDEX="7" placeholder="<?= $page[0]->timefin ?>" value="<?= $page[0]->timefin ?>" class="input-small">
			            <?= form_error('temps_fin'); ?>
			        </div>
			</div>
		<input type="hidden" name="chaine" id="chaine" value="<?= $numChaines ?>" />
		<input type="submit" class="btn" value="Update" />
	</fieldset>
</form>