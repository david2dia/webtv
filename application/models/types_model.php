<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Types_model extends CI_Model
{
	private $table = 'types';

	/**
	* Récupération des types
	* @return tableau de type
	*/
	public function getAll()
	{

		return $this->db->select('*')
						->from($this->table)
						->get()
						->result();
	}

}
?>