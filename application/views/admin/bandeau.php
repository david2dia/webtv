	<fieldset>
		<p>
			<legend id="legend">Strip Of Channel</legend>
			<div class="reponse alert alert-success span7 hide"></div>
			<div id="draglimite2">
				<table id="table" class="table table-condensed table-striped">
					<thead>
						<tr> 
							<th class="hide" width="30px">
								<a href="#" data-toggle="popover" data-placement="top" data-content="To change the order, you just need to drag and drop by selecting the link in the order column." title="" data-original-title="Information" onmouseover="$('#'+this.id).popover('show')" onmouseout="$('#'+this.id).popover('hide')">Order<sup>?</sup></a>
							</th>
							<th>Title</th> 
							<th>Message</th>  
							<th>&nbsp;</th> 
						</tr>
					</thead>
					<div id="loader2" class="hide"></div>
					<tbody id="tabsort2">
						<?php foreach($bandeaus as $bandeau): ?>
						<tr id="bandeau_<?= $bandeau->idbandeau; ?>">
							<td class='dragHandle2 hide' style="cursor: move"><?= $bandeau->ordre; ?></td> 
							<td><?= $bandeau->titremessage; ?></td>
							<td><?= $bandeau->message; ?></td>
							<td><a href="<?= site_url('admin/deletebandeau/'.$bandeau->idbandeau.'/'.$bandeau->idchaine); ?>" data-rel="tooltip" data-original-title="Delete" class="tooltipb"><i class="icon-trash"></i></a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</p>
	</fieldset>
<form action="<?= site_url('admin/ajoutbandeau') ?>" method="post">
<input type="text" class="input-large" name="titremessage" id="titremessage" maxlength="10" TABINDEX="1" placeholder="Enter Title of Message" required="required" />
<input type="text" class="input-xxlarge" name="message" id="message" TABINDEX="2" maxlength="70" placeholder="Enter Message" required="required" />
<input type="hidden" name="chaine" id="chaine" value="<?= $numChaines ?>" />
<input type="submit" class="btn" value="Add Message" />
</form>
