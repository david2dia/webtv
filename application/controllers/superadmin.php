<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Superadmin extends CI_Controller 
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
		
		$url = $as->getLoginURL();
		if (!$isAuth) {
			//$url = $as->getLoginURL();
			//echo '<p>You are not authenticated. <a href="' . htmlspecialchars($url) . '">Log in</a>.</p>';
			$as->requireAuth();
		} else {
			//$url = $as->getLogoutURL();
			//echo '<p>You are currently authenticated. <a href="' . htmlspecialchars($url) . '">Log out</a>.</p>';

			$attributes = $as->getAttributes();
			$uid = $attributes['uid'][0];
			$this->data['fed']['0'] = $uid;
			$this->data['fed']['1'] = $attributes['cn'][0];
			$this->data['fed']['2'] = $attributes['mail'][0];
			if($uid!='MDELOB06'&&$uid!='MRAKZA21'&&$uid!='Z18JVIGN') {
				echo "Utilisateur non autoris&eacute;s";
				redirect('welcome', 'refresh');
			}
		}
	} else {
		$this->data['fed']['0'] = "ID";
		$this->data['fed']['1'] = "NOM";
		$this->data['fed']['2'] = "MAIL";
	}
		// END System FED Oxylane
		
		//	Chargement des ressources pour tout le contrôleur
		$this->load->database();
		$this->load->helper('form');

		$this->load->library('form_validation');

		$this->load->model('pages_model', 'pm');
		$this->load->model('chaines_model', 'cm');
		$this->load->model('groupes_model', 'gm');
		$this->load->model('logs_model', 'lm');

	}

	/**
	*	fonction index
	*/
	public function index(){
		// on charge la page dans le template
		//Actualise les formulaires
		$this->form_validation->clear_field_data();
		$this->data['responsables'] = $this->cm->getAllResponsables();
		$this->data['channels'] = $this->cm->getAll();
		$this->data['groupes'] = $this->gm->getAll();
		$this->data['logs'] = $this->lm->getAll();
    		
		$this->accueil();
	}


	public function accueil(){

    		$this->template->set('title', 'Super Admin');
    		$this->template->load('templates/template', 'admin/super/accueil', $this->data);
	}


	/**
	*	Méthode de gestion des chaines en base
	*/
	public function channel()
	{			
		//	Cette méthode permet de changer les délimiteurs par défaut des messages d'erreur (<p></p>).
		$this->form_validation->set_error_delimiters('<p>', '</p>');
		
		//	Mise en place des règles de validation du formulaire
		$this->form_validation->set_rules('nom',  '"Name"',  'required');
		$this->form_validation->set_rules('description',  '"Description"',  'min_length[2]');
		$this->form_validation->set_rules('groupe', 'Groupe', 'required|is_natural_no_zero');
		$activelogo = ($this->input->post('activelogo') == 'on') ? 'true' : 'false';
		$activeband = ($this->input->post('activeband') == 'on') ? 'true' : 'false';
		if($this->form_validation->run())
		{
			//	Nous disposons d'une page sous une bonne forme
			//	Sauvegarde de la page dans la base de données
			 $this->cm->add($this->input->post('nom'),
			 						$this->input->post('groupe'),
			 					   	$this->input->post('description'),
			 					   	$this->input->post('urllogo'),
			 					    $this->input->post('responsable'),
			 					    $activelogo,
			 					    $activeband
			 					   );

			 //Actualise les formulaires
			$this->form_validation->clear_field_data();

			 //	Affichage de la confirmation
			$this->data['confirmation'] = '<div class="alert alert-success fade in"><a class="close" data-dismiss="alert">&times;</a><strong>Channel sucessfully added</strong></div>';
    		$this->index();
		}
		else
		{
			$this->data['confirmation'] = '<div class="alert alert-error fade in"><a class="close" data-dismiss="alert">&times;</a><strong>Channel failed added</strong></div>';
			$this->index();
		}
	}


	/**
	*	Méthode qui va update une chaine
	*/
	public function updateChannel()
	{	
		//	Cette méthode permet de changer les délimiteurs par défaut des messages d'erreur (<p></p>).
		$this->form_validation->set_error_delimiters('<p>', '</p>');
		
		//	Mise en place des règles de validation du formulaire
		$this->form_validation->set_rules('channel',  '"channel"',  'required|is_natural_no_zero');

		if($this->form_validation->run())
		{
			if($this->input->post('submit')=="Delete") {
				//	Nous disposons d'une page sous une bonne forme
				//	Suprimer le responsable
			 	$this->cm->delete($this->input->post('channel'));

			 	//	Affichage de la confirmation
				$this->data['confirmation'] = '<div class="alert alert-success fade in"><a class="close" data-dismiss="alert">&times;</a><strong>Channel sucessfully delete</strong></div>';
				$this->index();
			} else {
				$this->data['responsables'] = $this->cm->getAllResponsables();
				$this->data['groupes'] = $this->gm->getAll();
				$this->data['channel'] = $this->cm->get($this->input->post('channel'));
				$this->template->set('title', 'Update Channel');
    			$this->template->load('templates/template', 'admin/super/updatechannel', $this->data);
			}
		}
		else
		{
			$this->data['confirmation'] = '<div class="alert alert-error fade in"><a class="close" data-dismiss="alert">&times;</a><strong>Channel failed Update</strong></div>';
			$this->index();
		}
	}

		/**
	*	Méthode qui va update une chaine
	*/
	public function updateChannelBdd()
	{	
		//	Mise en place des règles de validation du formulaire
		$this->form_validation->set_rules('nom',  '"Nom"',  'required');
		$this->form_validation->set_rules('groupe', 'Groupe', 'required|is_natural_no_zero');
		$activelogo = ($this->input->post('activelogo') == 'on') ? 'true' : 'false';
		$activeband = ($this->input->post('activeband') == 'on') ? 'true' : 'false';

		if($this->form_validation->run())
		{
			//	Nous disposons d'une page sous une bonne forme
			//	Sauvegarde de la page dans la base de données
			 $this->cm->update($this->input->post('idchaine'),
			 						$this->input->post('nom'),
			 						$this->input->post('groupe'),
			 					   	$this->input->post('description'),
			 					   	$this->input->post('urllogo'),
			 					    $this->input->post('responsable'),
			 					    $activelogo,
			 					    $activeband
			 					   );

			 	//	Affichage de la confirmation
				$this->data['confirmation'] = '<div class="alert alert-success fade in"><a class="close" data-dismiss="alert">&times;</a><strong>Channel sucessfully Update</strong></div>';
				$this->index();
		}
		else
		{
			$this->data['confirmation'] = '<div class="alert alert-error fade in"><a class="close" data-dismiss="alert">&times;</a><strong>Channel failed Update TEst</strong></div>';
			$this->index();
		}
	}

	/**
	*	Méthode de gestion des groupe en base
	*/
	public function Groupe()
	{	
		//	Cette méthode permet de changer les délimiteurs par défaut des messages d'erreur (<p></p>).
		$this->form_validation->set_error_delimiters('<p>', '</p>');
		
		//	Mise en place des règles de validation du formulaire
		$this->form_validation->set_rules('nom',  '"Name"',  'required');
		$this->form_validation->set_rules('description',  '"Description"',  'min_length[2]');
		$this->form_validation->set_rules('groupe', 'Groupe', 'required');

		if($this->form_validation->run())
		{
			//	Nous disposons d'une page sous une bonne forme
			//	Sauvegarde de la page dans la base de données
			 $this->gm->add($this->input->post('nom'),
			 						$this->input->post('groupe'),
			 					   	$this->input->post('description'),
			 					   	$this->input->post('urllogo')
			 					   );

			 //Actualise les formulaires
			$this->form_validation->clear_field_data();

			 //	Affichage de la confirmation
			$this->data['confirmation'] = '<div class="alert alert-success fade in"><a class="close" data-dismiss="alert">&times;</a><strong>Group sucessfully added</strong></div>';
    		$this->index();
		}
		else
		{
			$this->data['confirmation'] = '<div class="alert alert-error fade in"><a class="close" data-dismiss="alert">&times;</a><strong>Group failed added</strong></div>';
			$this->index();
		}
	}

	/**
	*	Méthode qui va update une chaine
	*/
	public function updateGroupe()
	{	
		//	Cette méthode permet de changer les délimiteurs par défaut des messages d'erreur (<p></p>).
		$this->form_validation->set_error_delimiters('<p>', '</p>');
		
		//	Mise en place des règles de validation du formulaire
		$this->form_validation->set_rules('groupe',  '"groupe"',  'required|is_natural_no_zero');
		if($this->form_validation->run())
		{
			if($this->input->post('submit')=="Delete") {
				//	Nous disposons d'une page sous une bonne forme
				//	Suprimer le responsable
			 	$this->gm->delete($this->input->post('groupe'));

			 	//	Affichage de la confirmation
				$this->data['confirmation'] = '<div class="alert alert-success fade in"><a class="close" data-dismiss="alert">&times;</a><strong>Group sucessfully delete</strong></div>';
				$this->index();
			} else {
				$this->data['responsables'] = $this->cm->getAllResponsables();
				$this->data['parents'] = $this->gm->getAll();
				$this->data['groupe'] = $this->gm->get($this->input->post('groupe'));
				$this->template->set('title', 'Update Channel');
    			$this->template->load('templates/template', 'admin/super/updategroupe', $this->data);
			}
		}
		else
		{
			$this->data['confirmation'] = '<div class="alert alert-error fade in"><a class="close" data-dismiss="alert">&times;</a><strong>Group failed Update</strong></div>';
			$this->index();
		}
	}


	/**
	*	Méthode qui va update un groupe
	*/
	public function updateGroupeBdd()
	{	
		//	Mise en place des règles de validation du formulaire
		$this->form_validation->set_rules('nom',  '"Nom"',  'required');
		$this->form_validation->set_rules('groupe', 'Groupe', 'required');

		if($this->form_validation->run())
		{
			//	Nous disposons d'une page sous une bonne forme
			//	Sauvegarde de la page dans la base de données
			 $this->gm->update($this->input->post('idgroupe'),
			 						$this->input->post('nom'),
			 						$this->input->post('groupe'),
			 					   	$this->input->post('description'),
			 					   	$this->input->post('urllogo')
			 					   );

			 	//	Affichage de la confirmation
				$this->data['confirmation'] = '<div class="alert alert-success fade in"><a class="close" data-dismiss="alert">&times;</a><strong>Group sucessfully Update</strong></div>';
				$this->index();
		}
		else
		{
			$this->data['confirmation'] = '<div class="alert alert-error fade in"><a class="close" data-dismiss="alert">&times;</a><strong>Group failed Update</strong></div>';
			$this->index();
		}
	}


	/**
	*	Méthode de gestion des chaines en base
	*/
	public function multiChannel()
	{	

		//	Mise en place des règles de validation du formulaires
		$this->form_validation->set_rules('groupe',  '"Groupe"',  'required');
		
		if($this->form_validation->run())
		{
			//	Nous disposons d'une page sous une bonne forme

			//on verifie les valeurs et init si necesaire.
			$id = $this->input->post('groupe');
			$parents = $this->gm->getParentsId($id);
    		$chaine = $this->cm->getAllByMultiGroupe($parents);
			
			//	Sauvegarde de la page dans la base de données
			$this->pm->add($this->input->post('titre'),
				$this->input->post('url'),
				$temps,
				$datedeb,
				$datefin,
				$timedeb,
				$timefin,
				$this->input->post('chaine'),
				$public
				);


			
			//	Affichage de la confirmation
			$this->template->set('title', 'Confirmation');
			$this->data['confirmation'] = '<div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert">×</button><strong>Sucessfully added</strong><br />Url : '.$this->input->post('url').'</div>';
			$this->form_validation->clear_field_data();
			$this->administration($id);
		}
		else
		{
			// on charge la page dans le template
			$this->administration($id);

		}

	}

}

?>
