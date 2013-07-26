<div class="page-header">
	<h1>God</h1>
</div>
<div class="tabbable tabs-left"> 
	<ul class="nav nav-tabs">
		<li class="dropdown"><a href="<?= site_url('superadmin') ?>">Accueil</a></li>
		<li class="dropdown"> 
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">Channel<b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a href="#addchannel" data-toggle="tab">Add</a></li>
				<li><a href="#updatechannel" data-toggle="tab">Update/Delete</a></li>
			</ul>
		</li>
		<li class="dropdown"> 
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">Groupe<b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a href="#addgroupe" data-toggle="tab">Add</a></li>
				<li><a href="#updategroupe" data-toggle="tab">Update/Delete</a></li>
			</ul>
		</li>
		<li class="dropdown hide"> 
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">Multi Channels<b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a href="#addmultichannel"  data-toggle="tab">Add</a></li>
				<li><a href="#updatemultichannel" data-toggle="tab">Update/Delete</a></li>
			</ul>
		</li>
	</ul>
	<div class="tab-content">
		<?php if(isset($confirmation)) echo $confirmation; ?>
		<div class="tab-pane active" id="accueil">
			<p class="pull-right"><?= tagimg('logo-ITPI.png', 'logo', '400px', '400px') ?><p>
			<div class="hero-unit">
				<h1>Super Admin</h1>
				<p>Menu</p>
			</div>
		</div>
		<div class="tab-pane" id="addchannel"><?= $this->load->view("admin/super/addchannel"); ?></div>
		<div class="tab-pane" id="updatechannel"><?= $this->load->view("admin/super/channel"); ?></div>
		<div class="tab-pane" id="addgroupe"><?= $this->load->view("admin/super/addgroupe"); ?></div>
		<div class="tab-pane" id="updategroupe"><?= $this->load->view("admin/super/groupe"); ?></div>
		<div class="tab-pane" id="addmultichannel"><?= $this->load->view("admin/super/addchannel"); ?></div>
		<div class="tab-pane" id="updatemultichannel"><?= $this->load->view("admin/super/addchannel"); ?></div>
	</div>
</div>