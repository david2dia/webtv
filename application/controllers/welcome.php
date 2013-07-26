<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	private $data;

		public function __construct()
	{
		//	Obligatoire
		parent::__construct();
		//	Chargement des ressources pour tout le contrôleur
		$this->load->database();
		$this->load->helper('form');

		$this->load->model('pages_model', 'pm');
		$this->load->model('types_model', 'tm');
		$this->load->model('chaines_model', 'cm');
		$this->load->model('groupes_model', 'gm');

		$this->data = array();

		// Récupération de toute les chaines
		/*$this->data['chaines'] = $this->cm->getAll();*/
		$this->data['chaines'] = array();
		$this->data['nbchaine'] = $this->cm->getNb();
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	/**
	*	fonction index
	*/
	public function index($id=''){
		// on charge la page dans le template
    	$this->liste($id);
	}


	public function liste($id=''){
		if($id != null){
			$id = (integer)$id;
			$this->data['groupes'] = $this->gm->getChild($id);
			$this->data['chaines'] = $this->cm->getAllByGroupe($id);
		} else $this->data['groupes'] = $this->gm->getAllParent();
		$this->template->set('title', 'WebTv - Oxylane');
    	$this->template->load('templates/template', 'affichage', $this->data);
	}

	
	public function groupe($id=''){
		if($id != null){
			$id = (integer)$id;
			$this->data['groupes'] = $this->gm->getChild($id);
			$this->data['chaines'] = $this->cm->getAllByGroupe($id);
		} else $this->data['groupes'] = $this->gm->getAllParent();

		foreach($this->data['groupes'] as $groupe) {
				echo "<a href='http://localhost/webtv/welcome/groupe/".$groupe->idgroupe."'>".$groupe->nom."</a>";
				echo "<br>";
			}
		$this->template->set('title', 'WebTv - Oxylane');
    	$this->template->load('templates/template', 'affichage', $this->data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

?>