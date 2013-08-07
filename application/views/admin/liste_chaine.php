<?php $this->load->helper('text');  ?>
	<fieldset>
		<p>
			<legend id="legend">Pages Of Channel</legend>
			<div class="reponse alert alert-success span7 hide"></div>
			<div id="draglimite">
				<table id="table" class="table table-condensed table-striped">
					<thead>
						<tr> 
							<th width="30px">
								<a href="#" data-toggle="popover" data-placement="top" data-content="To change the order, you just need to drag and drop by selecting the link in the order column." title="" data-original-title="Information" onmouseover="$('#'+this.id).popover('show')" onmouseout="$('#'+this.id).popover('hide')">Order<sup>?</sup></a>
							</th>
							<th>Title</th> 
							<th>Length</th>  
							<th>&nbsp;</th> 
						</tr>
					</thead>
					<div id="loader" class="hide"></div>
					<tbody id="tabsort">
						<?php foreach($pages as $page): ?>
						<?php $valide=true; if ($page->datedebut>mdate("%Y-%m-%d", time()) OR $page->datefin<mdate("%Y-%m-%d", time()) OR ($page->timedebut >= mdate("%H:%i:%s", time()) OR $page->timefin <= mdate("%H:%i:%s", time()))) $valide=false; ?>
						<tr id="page_<?= $page->idpage; ?>" <?php if(!$valide) echo 'class="text-error"' ?>>
							<td class='dragHandle' style="cursor: move"><?= $page->ordre; ?></td> 
							<td><?php if(!$valide) echo '<strong>' ?><?= character_limiter($page->titre,90); ?><?php if(!$valide) echo '</strong>' ?></td>
							<td><?= $page->temps; ?> s</td>
							<td>
								<a href="<?= site_url('admin/delete/'.$page->idpage.'/'.$page->idchaine); ?>" data-rel="tooltip" data-original-title="Delete" class="tooltipb"><i class="icon-trash"></i></a>
								<a href="<?= site_url('admin/update/'.$page->idpage.'/'.$page->idchaine); ?>" data-rel="tooltip" data-original-title="Update" class="tooltipb"><i class="icon-pencil"></i></a>
								<i class="icon-time" id="helphour_<?= $page->idpage; ?>" data-toggle="popover" data-placement="right" data-html="true" data-content="From <?= $page->datedebut; ?> To <?= $page->datefin; ?><br>From <?= $page->timedebut; ?> To <?= $page->timefin; ?>" data-original-title="Timing" onmouseover="$('#'+this.id).popover('show')" onmouseout="$('#'+this.id).popover('hide')"></i>
								<a rel="tooltip" id="tooltip" href="<?= $page->url; ?>" data-rel="tooltip" data-original-title="Show" class="tooltipb" target='_blank'><i class="icon-eye-open"></i></a>
								<a rel="tooltip" id="tooltip" data-rel="tooltip" data-original-title="<?= $page->auteur; ?>" class="tooltipb"><i class="icon-user"></i></a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</p>
	</fieldset>
