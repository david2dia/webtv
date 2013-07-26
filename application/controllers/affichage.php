<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Affichage extends CI_Controller 
{
	private $data; 
	
	public function __construct()
	{
		//	Obligatoire
		parent::__construct();
		
		//	Chargement des ressources pour tout le contrôleur
		$this->load->database();
		$this->load->helper('tabphptojs');

		$this->load->model('pages_model', 'pm');
		$this->load->model('bandeau_model', 'bm');
		$this->load->model('types_model', 'tm');
		$this->load->model('chaines_model', 'cm');

		$this->data = array();

		// Récupération des types de page
		$this->data['types'] = $this->tm->getAll();
	}

	/**
	*	fonction index
	*/
	public function index(){
		// on charge la page dans le template
    	$this->voir_chaine();
	}


	public function voir_chaine($chaine=''){
		$chaine = (integer)$chaine;
		// Si on a séléctionné une chaine on affiche le formulaire
		// Sinon on affiche que les chaines
    	if ($chaine != null && $this->cm->verifChaine($chaine)==1){
    		// $id = $this->input->get('chaine');
    		$id = $chaine;

    		// on ajoute le numero de la chaine, les infos de la chaine
    		$this->data['numChaines'] = $id;
    		$this->data['infos'] = $this->cm->get($id);
    		$this->data['bandeaus'] = $this->bm->getAllByChaine($id);
    		$pages = $this->pm->getAllByChaineIsValide($id);
			
			$pagesjs = array();
			$ind=0;
			foreach($pages as $page) {
				$pagesjs[$ind] = array($page->idpage,$page->url,$page->temps."000",'frame');
		        $ind++;
			}
			$this->data['pages'] = php2js($pagesjs);

    		$this->load->view('iframe', $this->data);
/*    		$this->template->load('templates/template', 'iframe', $this->data);*/
    	}else{
    		redirect('/welcome');
    	}
	}

	public function tisaniere(){
    		$pages = $this->pm->getAll();
			
			$pagesjs = array();
			$ind=0;
			foreach($pages as $page) {
				$pagesjs[$ind] = array($page->idpage,$page->url,"20000",'frame');
		        $ind++;
			}
			$this->data['pages'] = php2js($pagesjs);
    		$this->load->view('iframe', $this->data);
	}

}