<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admins_model extends CI_Model
{
	private $table = 'admins';
	private $tableid = 'idadmin';

	/**
	* Récupération un groupe
	* @return tableau d'information
	*/
	public function get($id)
	{
		return $this->db->select('*')
						->from($this->table)
						->where(array($this->tableid => $id))
						->get()
						->result();
	}

	/**
	* Récupération des groupes
	* @return tableau de groupes
	*/
	public function getAll()
	{
	return $this->db->from($this->table)
						->get()
						->result();
	}


	/**
	* Supprime un groupe par son Id
	* @param int  $id	id du groupe
	* @return bool		Le résultat de la requête
	*/
	public function delete($id)
	{
		return $this->db->where($this->tableid, $id)
						->delete($this->table);
	}

}

?>