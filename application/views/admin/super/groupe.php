<section class="row">
	<form class="span6" method="post" action="<?= site_url('superadmin/updateGroupe/'); ?>">
		<fieldset>
			<legend>Settings Group</legend>
				<div>
					<select id="groupe" class="input-block-level" name="groupe" required="required">
						<option value="">Choose Group</option>
						<?php foreach($groupes as $groupe): ?>
								<option value="<?= $groupe->idgroupe ?>"><?= $groupe->nom; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
		</fieldset>
			<input type="submit" name="submit" class="btn btn-primary btn-large btn-warning" value="Update" />
			<input type="submit" name="submit" class="btn btn-primary btn-large btn-danger" value="Delete" />
	</form>
</section>