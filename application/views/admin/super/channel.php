<section class="row">
	<form class="span6" method="post" action="<?= site_url('superadmin/updateChannel/'); ?>">
		<fieldset>
			<legend>Settings Channel</legend>
				<div>
					<select id="channel" class="input-block-level" name="channel" required="required">
						<option value="">Choose Channel</option>
						<?php foreach($channels as $channel): ?>
								<option value="<?= $channel->idchaine ?>"><?= $channel->nom; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
		</fieldset>
			<input type="submit" name="submit" class="btn btn-primary btn-large btn-warning" value="Update" />
			<input type="submit" name="submit" class="btn btn-primary btn-large btn-danger" value="Delete" />
	</form>
</section>