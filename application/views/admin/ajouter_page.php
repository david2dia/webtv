<?= $this->load->view("admin/chaines"); ?>
<div id="chaine_conteneur">
	<?= $this->load->view("admin/postit"); ?>
	<?= $this->load->view("admin/liste_chaine"); ?>
			<form class="form-horizontal" id="add" action="<?= site_url('admin/ajoutLite') ?>" method="post" novalidate>
				<div>
					<fieldset>
						<legend><?= $infos[0]->nom ?><small> ( <?= $infos[0]->groupe ?> )</small></legend>
						<div class="alert rounded-corners hide">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
				    		<strong>Fast Add Mode</strong>
				    		<ul>
				    			<li>Copier-Coller une url pour ajouter rapidement une Page à la chaine</li>
						    	<li>Le Temps est faculatitive il est fixé a 30 secondes par defaut.</li>
						    	<li>More option.</li>
						    </ul>
				    	</div>
						<?php if(isset($confirmation)) echo $confirmation ?>
						<div class="control-group">
							<label class="control-label" for="url"><abbr data-rel="tooltip" data-original-title="Required" class="tooltipb">*</abbr>URL :</label>
							<div class="controls">
								<input type="url" class="input-xxlarge" name="url" id="url" TABINDEX="1" placeholder="Enter website address" value="<?= set_value('url'); ?>" required="required" />
								<div class="help-block alert alert-sur hide"></div>
								<?= form_error('url'); ?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="temps">Length (in s) :</label>
							<div class="controls">
								<input type="number" min="1" max="3600" class="input-small" name="temps" id="temps" TABINDEX="2" value="<?= set_value('temps'); ?>" />
								<?= form_error('temps'); ?>
							</div>
						</div>
						<div class="control-group hide">
							<label class="control-label" for="public">Public Page :</label>
							<div class="controls">
								<input type="checkbox" name="public" id="public" TABINDEX="3">
								<?= form_error('public'); ?>
							</div>
						</div>
						<div class="form-actions">  
            				<input type="hidden" name="chaine" id="chaine" value="<?= $numChaines ?>" />
							<input type="submit" class="btn" value="Add Page" />
							<a href="<?= site_url('admin/edition/'.$numChaines); ?>" class="btn">More options</a>
          				</div> 
					</fieldset>
				</div>
			</form>
</div>