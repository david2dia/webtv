<div>
	<form method="post" action="<?= ('admin/voir_chaine'); ?>">
		<div>
			<label>
				Chaine :
				<select name="num_chaines" class="chzn-select" onchange='this.form.submit()'>
					<?php foreach($chaines as $chaine): ?>
						<option value="<?php echo $chaine->idchaine; ?>"><?php echo $chaine->nom; ?></option>
					<?php endforeach; ?>
				</select>
			</label>
		</div>
	</form>
<div>