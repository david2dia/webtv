<section class="row">
	<table class="span10 text-center">
		<tr>
			<th width="10px">ID</th>
			<th>AUTEUR</th>
			<th>ACTION</th>
			<th>INFORMATIONS</th>
			<th>DATE</th>
		</tr>
		<?php foreach($logs as $log): ?>
		<tr>
			<td><?= $log->idlogs; ?></td>
			<td><a href="mailto:<?= $log->mail; ?>"><?= $log->nom; ?></a></td>
			<td><?= $log->action; ?> <?= $log->type; ?></td>
			<td><?= $log->detail; ?></td>
			<td><?= $log->date; ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
</section>