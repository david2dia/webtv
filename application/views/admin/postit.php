<article id="postit" class="pull-right post-it fade in shadow visible-desktop">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<ul class="unstyled">
		<li><h3><?= $infos[0]->nom ?></h3></li>
<!-- 		<li>Responsable : <?= safe_mailto($infos[0]->responsablemail,$infos[0]->responsable); ?></li> -->
		<li>Responsable : <?= $infos[0]->responsable; ?></li>
		<?php if ($nbliens!=0): ?><li>Nb de Pages : <?= $nbliens ?></li><?php endif; ?>
		<?php if ($tempssequence[0]->temps!=NULL): ?><li>Durée Sequence : <?= $tempssequence[0]->temps ?> sec</li><?php endif; ?>
	</ul>
</article>