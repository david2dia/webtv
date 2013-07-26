<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conversion extends CI_Controller 
{

private $data;

	public function __construct()
	{
		//	Obligatoire
		parent::__construct();
		
		//	Chargement des ressources pour tout le contrôleur
		$this->load->database();
		$this->load->helper('form');
		$this->load->helper('convertlien_helper');

		$this->load->model('pages_model', 'pm');
		$this->load->model('types_model', 'tm');
		$this->load->model('chaines_model', 'cm');

		$this->data = array();
		
	}

	/**
	*	fonction index
	*/
	public function index(){
		// on charge la page dans le template
    	$this->affichageConversion();
	}

	public function affichageConversion(){
		// Si on a une url, on la convertie
		// Sinon on affiche le message d'erreur
    	if ($this->input->get('url') != null) $this->data['url'] = getUrlPartage($this->input->get('url'));
    	else $this->data['url'][0] = 'Aucune URL';

    	$this->template->set('title', 'Conversion');
    	$this->template->load('templates/template', 'conversion', $this->data);

	}
}

?>