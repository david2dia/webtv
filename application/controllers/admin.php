<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller 
{
	private $data; 
	
	public function __construct()
	{
		//	Obligatoire
		parent::__construct();
		$this->data = array();

		// System FED Oxylane
	if (FEDACTIVE) {
		require(__DIR__.'/../simplesaml/lib/_autoload.php');
		$as = new SimpleSAML_Auth_Simple('Oxylane-sp');
		$isAuth = $as->isAuthenticated();
		if (!$isAuth) {
			$as->requireAuth();
		} else {
			$attributes = $as->getAttributes();
			$this->data['fed']['0'] = $attributes['uid'][0]; //identifiant
			$this->data['fed']['1'] = $attributes['cn'][0]; //nom de la personne
			$this->data['fed']['2'] = $attributes['mail'][0]; //mail de la personne
		}
	} else {
		$this->data['fed']['0'] = "ID";
		$this->data['fed']['1'] = "NOM";
		$this->data['fed']['2'] = "MAIL";
	}
		// END FED


		//	Chargement des ressources pour tout le contrôleur
		$this->load->database();
		$this->load->helper('form');
		$this->load->helper('titreUrl');
		$this->load->helper('convertlien');

		$this->load->library('form_validation');

		$this->load->model('pages_model', 'pm');
		$this->load->model('plannings_model', 'plm');
		$this->load->model('types_model', 'tm');
		$this->load->model('chaines_model', 'cm');
		$this->load->model('groupes_model', 'gm');
		$this->load->model('bandeau_model', 'bm');
		if(FEDLOG) $this->load->model('logs_model', 'lm');

		// Récupération de toute les chaines
		$this->data['chaines'] = $this->cm->getAll();
		$this->data['superadmin'] = true;

		//	Cette méthode permet de changer les délimiteurs par défaut des messages d'erreur (<p></p>).
		$this->form_validation->set_error_delimiters('<p class="alert alert-error fade in"><a class="close" data-dismiss="alert" href="#">&times;</a>', '</p>');
	}

	/**
	*	fonction index
	*/
	public function index(){
		// on charge la page dans le template
		$this->voir_chaine();
	}


	public function voir_chaine($id='',$chainepam=''){
		//require_once('http://localhost/simplesaml/lib/_autoload.php');
		//$this->load->library('simplesaml/lib/_autoload');
		//$auth = new SimpleSAML_Auth_Simple('default-sp');
		//echo $auth->isAuthenticated();
		$chaine = (integer)$this->input->post('num_chaines');
		if($chainepam!=null) $chaine = (integer)$chainepam;

		//$this->data['chaines'] = array();
/*		if($id != null){
			$id = (integer)$id;
			$this->data['groupes'] = $this->gm->getChild($id);
			$this->data['chaines'] = $this->cm->getAllByGroupe($id);
		} else $this->data['groupes'] = $this->gm->getAllParent();*/

		// Si on a séléctionné une chaine on affiche le formulaire
		// Sinon on affiche que les chaines
		if ($chaine != null && $this->cm->verifChaine($chaine)==1){
			$id = ($chainepam!=null) ? $chainepam : $this->input->post('num_chaines');
			$this->data['chaines'] = $this->cm->getAll();

    		// on ajoute le numero de la chaine, les infos de la chaine
			$this->data['numChaines'] = $id;
			$this->data['infos'] = $this->cm->get($id);
    		// on ajoute le nombre de pages et le temps de la sequence
			$this->data['nbliens'] = $this->pm->getNbLiens($id);
			$this->data['tempssequence'] = $this->pm->getTempsSequence($id);
			// Récupération de toute les pages
			$this->data['pages'] = $this->pm->getAllByChaine($id);

			$this->template->set('title', 'Add Page - '.$this->data['infos'][0]->nom);
			$this->template->load('templates/template', 'admin/ajouter_page', $this->data);
		}else{
			$this->template->set('title', 'Administration Channel');
			$this->template->load('templates/template', 'admin/chaines', $this->data);
		}
	}


	/**
	*	Méthode qui va ajouter une page en base
	*/
	public function ajout()
	{	

			// on ajoute le numero de la chaine, les infos de la chaine
		$id = $this->input->post('chaine');
/*		$this->data['numChaines'] = $id;
		$this->data['infos'] = $this->cm->get($id);
    		// on ajoute le nombre de pages et le temps de la sequence
		$this->data['nbliens'] = $this->pm->getNbLiens($id);
		$this->data['tempssequence'] = $this->pm->getTempsSequence($id);*/
		
		//	Cette méthode permet de changer les délimiteurs par défaut des messages d'erreur (<p></p>).
		//$this->form_validation->set_error_delimiters('<p>', '</p>');
		//$this->form_validation->set_error_delimiters('<p class="alert alert-error" data-animation="true"><a class="close" data-dismiss="alert" href="#">&times;</a>', '</p>');
		
		//	Mise en place des règles de validation du formulaire
		//	Uniquement des caractères alphanumériques, des tirets et des underscores
		$this->form_validation->set_rules('titre',  '"Titre"',  'trim|required|min_length[3]|max_length[300]|xss_clean');
		$this->form_validation->set_rules('url', '"URL"', 'trim|required|min_length[3]|max_length[500]|prep_url|xss_clean');
		$this->form_validation->set_rules('temps', '"Temps"', 'trim|max_length[5]|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('date_debut', '"Date debut"', 'valid_date|xss_clean');
		$this->form_validation->set_rules('date_fin', '"Date fin"', 'valid_date|xss_clean');
		$this->form_validation->set_rules('time_debut', '"Temps début"', 'trim|xss_clean');
		$this->form_validation->set_rules('time_fin', '"Temps fin"', 'trim|xss_clean');
		$this->form_validation->set_rules('chaine', '"Chaine"', 'trim|required|is_natural_no_zero|xss_clean');
		
		if($this->form_validation->run())
		{
			//	Nous disposons d'une page sous une bonne forme

			//on verifie les valeurs et init si necesaire.
			$public = ($this->input->post('public') == 'on') ? 'true' : 'false';
			$temps = ($this->input->post('temps') == '') ? '60' : $this->input->post('temps');
			$datedeb = $this->input->post('date_debut');
			$datefin = $this->input->post('date_fin');
			$timedeb = $this->input->post('time_debut');
			$timefin = $this->input->post('time_fin');
			if ($datedeb==null) $datedeb = mdate("%Y-%m-%d", time());
			if ($datefin==null) $datefin = mdate("%Y-%m-%d", strtotime('+1 years'));
			if ($timedeb==null) $timedeb = '00:01';
			if ($timefin==null) $timefin = '23:59';
			$hebdo = '1;2;3;4;5;6;7';
			
			//Sauvegarde de la page dans la base de données
			$this->pm->add($this->input->post('titre'),
				$this->input->post('url'),
				$temps,
				$datedeb,
				$datefin,
				$timedeb,
				$timefin,
				$hebdo,
				$this->input->post('chaine'),
				$public,
				$this->data['fed']['1']
				);

			//Ajout du Log
			if(FEDLOG) $this->lm->add("Ajout","Page",$this->input->post('url')." sur ".$this->input->post('chaine'));


			
			//	Affichage de la confirmation
			$this->template->set('title', 'Confirmation');
			$this->data['confirmation'] = '<div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert">×</button><strong>Sucessfully added</strong><br />Url : '.$this->input->post('url').'</div>';
			$this->form_validation->clear_field_data();
			$this->edition($id);
		}
		else
		{
			// on charge la page dans le template
			$this->edition($id);

		}

	}

	/**
	*	Méthode qui va ajouter une page en base
	*/
	public function ajoutLite()
	{
		//	Cette méthode permet de changer les délimiteurs par défaut des messages d'erreur (<p></p>).
		//$this->form_validation->set_error_delimiters('<p class="alert alert-error">', '</p>');
		
		//	Mise en place des règles de validation du formulaire
		//	Uniquement des caractères alphanumériques, des tirets et des underscores
		$this->form_validation->set_rules('url', '"URL"', 'trim|required|min_length[5]|xss_clean|prep_url');
		$this->form_validation->set_rules('temps', '"Temps"', 'trim|is_natural_no_zero|max_length[5]|xss_clean');
		$this->form_validation->set_rules('chaine', '"Chaine"', 'trim|numeric|required|is_natural_no_zero|xss_clean');
		if($this->form_validation->run())
		{
			$public = ($this->input->post('public') == 'on') ? 'true' : 'false';
			$temps = ($this->input->post('temps') == '') ? '60' : $this->input->post('temps');
			//	Nous disposons d'une page sous une bonne forme
			
			//	Sauvegarde de la page dans la base de données
			$this->pm->addLite(
				$this->input->post('url'),
				$temps,
				$this->input->post('chaine'),
				$public,
				$this->data['fed']['1']
				);

			//Ajout du Log
			if(FEDLOG) $this->lm->add("Ajout_Lite","Page",$this->input->post('url')." sur ".$this->input->post('chaine'));
			
			//	Affichage de la confirmation
			$this->template->set('title', 'Confirmation');
			$this->data['confirmation'] = '<div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert">×</button><strong>Sucessfully added</strong><br />Url : '.$this->input->post('url').'</div>';
			$this->form_validation->clear_field_data();
			$this->voir_chaine(0,$this->input->post('chaine'));
			//redirect('admin/voir_chaine/'.$this->input->post('chaine'), 'refresh');
		}
		else
		{
			$this->voir_chaine(0,$this->input->post('chaine'));
			//redirect('admin/voir_chaine/'.$this->input->post('chaine'), 'refresh');
		}

	}

	/**
	*	Méthode de gestion des chaines en base
	*/
	public function ajoutMultiple()
	{	
		$this->template->set('title', 'Multi Chaine');
		$this->data['groupes'] = $this->gm->getAll();

		//	Mise en place des règles de validation du formulaires
		$this->form_validation->set_rules('groupe',  '"Groupe"',  'required|is_natural_no_zero');
		$this->form_validation->set_rules('titre',  '"Titre"',  'trim|required|min_length[3]|max_length[300]|xss_clean');
		$this->form_validation->set_rules('url', '"URL"', 'trim|required|min_length[3]|max_length[500]|prep_url|xss_clean');
		$this->form_validation->set_rules('temps', '"Temps"', 'trim|max_length[5]|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('date_debut', '"Date début"', 'valid_date|xss_clean');
		$this->form_validation->set_rules('date_fin', '"Date fin"', 'valid_date|xss_clean');
		$this->form_validation->set_rules('time_debut', '"Temps début"', 'trim|xss_clean');
		$this->form_validation->set_rules('time_fin', '"Temps fin"', 'trim|xss_clean');
		
		if($this->form_validation->run())
		{
			//	Nous disposons d'une page sous une bonne forme

			//on recupere les informations
			$id = $this->input->post('groupe');
			//SPECIFIQUE PSQL
			$parents = $this->gm->getParentsId($id);
			//SPECIFIQUE PSQL
    			$chaines = $this->cm->getAllByMultiGroupe($parents);
    			$groupe = $this->gm->get($id);

    		//on verifie les valeurs et init si necesaire.
			$public = ($this->input->post('public') == 'on') ? 'true' : 'false';
			$temps = ($this->input->post('temps') == '') ? '60' : $this->input->post('temps');
			$datedeb = $this->input->post('date_debut');
			$datefin = $this->input->post('date_fin');
			$timedeb = $this->input->post('time_debut');
			$timefin = $this->input->post('time_fin');
			if ($datedeb==null) $datedeb = mdate("%Y-%m-%d", time());
			if ($datefin==null) $datefin = mdate("%Y-%m-%d", strtotime('+1 years'));
			if ($timedeb==null) $timedeb = '00:01';
			if ($timefin==null) $timefin = '23:59';
			$hebdo = '1;2;3;4;5;6;7';

    		foreach($chaines as $chaine) {
				//	Sauvegarde de la page dans la base de données
				$this->pm->add($this->input->post('titre'),
					$this->input->post('url'),
					$temps,
					$datedeb,
					$datefin,
					$timedeb,
					$timefin,
					$hebdo,
					$chaine->idchaine,
					$public,
					$this->data['fed']['1']
					);
			}

				//Ajout du Log
				if(FEDLOG) $this->lm->add("Ajout_Multiple","Page",$this->input->post('url'));


			
			//	Affichage de la confirmation
			$this->data['confirmation'] = '<div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert">×</button><strong>Sucessfully added</strong><br />Groupe : '.$groupe[0]->nom.'</div>';
			$this->form_validation->clear_field_data();
			$this->template->load('templates/template', 'admin/ajout_multiple', $this->data);
		}
		else
		{
			// on charge la page dans le template
			if ($this->input->post('groupe')=="false") $this->data['confirmation'] = '<div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">×</button><strong>failed added</strong></div>';
			$this->template->load('templates/template', 'admin/ajout_multiple', $this->data);

		}

	}

	public function ajoutBandeau()
	{
		$this->form_validation->set_rules('titremessage', '"titremessage"', 'trim|required|xss_clean');
		$this->form_validation->set_rules('message', '"message"', 'trim|required|xss_clean');
		$this->form_validation->set_rules('chaine', '"Chaine"', 'trim|numeric|required|is_natural_no_zero|xss_clean');
		if($this->form_validation->run())
		{
			//	Sauvegarde du message dans la base de données
			$this->bm->add(
				$this->input->post('chaine'),
				$this->input->post('titremessage'),
				$this->input->post('message'),
				"1"
				);
			
			
			//	Affichage de la confirmation
			$this->template->set('title', 'Confirmation');
			$this->data['confirmation'] = '<div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert">×</button><strong>Sucessfully added</strong> Message</div>';
			$this->form_validation->clear_field_data();
			$this->edition($this->input->post('chaine'));
		}
		else
		{
			$this->edition($this->input->post('chaine'));
		}
	}

	/**
	*	Méthode Gere une chaines ordre des pages
	*/
	public function edition($chaine='')
	{	
		$chaine = (integer)$chaine;
		// Si on a séléctionné une chaine on affiche les pages
		// Sinon on affiche que les chaines
		if ($chaine != null && $this->cm->verifChaine($chaine)==1){
    		// $id = $this->input->get('chaine');
			$id = $chaine;

    		// Récupération de toute les pages
			$this->data['pages'] = $this->pm->getAllByChaine($id);

			// Récupération du bandeau
			$this->data['bandeaus'] = $this->bm->getAllByChaine($id);

    		// on ajoute le numero de la chaine, les infos de la chaine
			$this->data['numChaines'] = $id;
			$this->data['infos'] = $this->cm->get($id);
    		// on ajoute le nombre de pages et le temps de la sequence
			$this->data['nbliens'] = $this->pm->getNbLiens($id);
			$this->data['tempssequence'] = $this->pm->getTempsSequence($id);


			$this->data['edition'] = true;
			$this->template->set('title', $this->data['infos'][0]->nom);
			$this->template->load('templates/template', 'admin/administrer_chaine', $this->data);
		}else{
			$this->voir_chaine();
		}
	}

	/**
	*	Méthode qui va modifier une page en base
	*/
	public function update($page,$numChaine)
	{
		$this->data['numChaines'] = $numChaine;
		$this->data['chaine'] = $this->cm->get($numChaine);
		$this->data['page'] = $this->pm->get($page);
		
		//	Cette méthode permet de changer les délimiteurs par défaut des messages d'erreur (<p></p>).
		//$this->form_validation->set_error_delimiters('<p>', '</p>');
		//$this->form_validation->set_error_delimiters('<p class="alert alert-error" data-animation="true"><a class="close" data-dismiss="alert" href="#">&times;</a>', '</p>');
		
		//	Mise en place des règles de validation du formulaire
		//	Uniquement des caractères alphanumériques, des tirets et des underscores

		$this->form_validation->set_rules('titre',  '"Titre"',  'trim|required|min_length[3]|max_length[300]|xss_clean');
		$this->form_validation->set_rules('url', '"URL"', 'trim|required|min_length[3]|max_length[500]|xss_clean');
		$this->form_validation->set_rules('temps', '"Temps"', 'trim|max_length[5]|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('date_debut', '"Date début"', 'valid_date|xss_clean');
		$this->form_validation->set_rules('date_fin', '"Date fin"', 'valid_date|xss_clean');
		$this->form_validation->set_rules('time_debut', '"Temps début"', 'trim|xss_clean');
		$this->form_validation->set_rules('time_fin', '"Temps fin"', 'trim|xss_clean');
		$this->form_validation->set_rules('chaine', '"Chaine"', 'trim|required|is_natural_no_zero|xss_clean');
		
		if($this->form_validation->run())
		{
			//	Nous disposons d'une page sous une bonne forme

			//on verifie les valeurs et init si necesaire.
			$public = ($this->input->post('public') == 'on') ? 'true' : 'false';
			$temps = ($this->input->post('temps') == '') ? '60' : $this->input->post('temps');
			$datedeb = $this->input->post('date_debut');
			$datefin = $this->input->post('date_fin');
			$timedeb = $this->input->post('time_debut');
			$timefin = $this->input->post('time_fin');
			if ($datedeb==null) $datedeb = mdate("%Y-%m-%d", time());
			if ($datefin==null) $datefin = mdate("%Y-%m-%d", strtotime('+1 years'));
			if ($timedeb==null) $timedeb = '23:59';
			if ($timefin==null) $timefin = '00:01';
			$idplanning = $this->data['page'][0]->idplanning;
			
			//	Sauvegarde de la page dans la base de données
				$this->pm->update(
				$page,
				$this->input->post('titre'),
				$this->input->post('url'),
				$temps,
				$datedeb,
				$datefin,
				$timedeb,
				$timefin,
				$idplanning,
				$this->input->post('chaine'),
				$public,
				$this->data['fed']['1']
				);

			//Ajout du Log
			if(FEDLOG) $this->lm->add("Update","Page", $this->input->post('url')." sur ".$this->input->post('chaine'));


			
			//	Affichage de la confirmation
			$this->template->set('title', 'Confirmation');
			$this->data['confirmation'] = '<div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert">×</button><strong>Sucessfully Updated</strong><br />Url : '.$this->input->post('url').'</div>';
			$this->form_validation->clear_field_data();
			$this->edition($numChaine);
		}
		else
		{
			// on charge la page dans le template
			$this->template->set('title', 'Update');
			$this->template->load('templates/template', 'admin/update_page', $this->data);
		}
	}

	/**
	*	Méthode qui va supprime une page en base
	*/
	public function delete($page,$numChaine)
	{
		//	Suprimer la page
		$idplanning = $this->pm->get($page);
		$url = $idplanning[0]->url;
		$idplanning = $idplanning[0]->idplanning;
		$this->pm->delete($page);
		//Ajout du Log
		if(FEDLOG) $this->lm->add("Delete","Page", $url." sur ".$numChaine);
		if($idplanning!=1) $this->plm->delete($idplanning);
		$page = $this->pm->getAllByChaine($numChaine);
		$order=0;
		foreach($page as $idPage )
		{
			$order+=1;
    		$this->pm->setOrdre($idPage->idpage,$order);
		}
		//$this->edition($numChaine);
		redirect('admin/edition/'.$numChaine, 'refresh');
	}

	public function deletebandeau($message,$numChaine)
	{
		//	Suprimer un message du bandeau
		$this->bm->delete($message);
		$bandeaus = $this->bm->getAllByChaine($numChaine);
		$this->edition($numChaine);
	}

	/**
	*	Méthode qui va enregistrer l'ordre des page en base
	*/
	public function saveOrder()
	{	
		//var_dump($this->input->post('page'));
		$page = $this->input->post('page');

		// changement de l'ordre des page
		foreach( $page as $order => $idPage )
		{
			$order+=1;
    		$this->pm->setOrdre($idPage,$order);
		}
		echo "<strong>Successfully</strong> Update Order";
	}

}

?>
