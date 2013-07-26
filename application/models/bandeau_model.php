<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bandeau_model extends CI_Model
{
	private $table = 'bandeau';
	private $tableid = 'idbandeau';


	/**
	* Récupération des message
	* @return tableau de message
	*/
	public function getAll()
	{
		return $this->db->select('*')
						->from($this->table)
						->get()
						->result();
	}

	/**
	* Récupération des message d'une chaine
	* @return tableau de chaines
	*/
	public function getAllByChaine($id)
	{
		return $this->db->select('*')
						->from($this->table)
						->where(array('idchaine' => $id))
						->get()
						->result();
	}

	/**
	* Verifie q'un bandeau est active
	* @param int  $id	id de la chaine
	* @return true / false
	*/
	public function verifActive($id)
	{
		return $this->db->select('activeband')
						->from('chaines')
						->where(array('idchaine' => $id))
						->get()
						->result();
	}


	public function add($idchaine, $titremessage, $message, $ordre)
	{
		return $this->db->set(array('idchaine' => $idchaine,
									'titremessage' => $titremessage,
									'message' => $message,
				    				'ordre' => $ordre,
				    				))
						->insert($this->table);
	}


	public function update($idmessage, $idchaine, $titremessage, $message, $ordre)
	{
		return $this->db->set(array('idchaine' => $idchaine,
									'titremessage' => $titremessage,
									'message' => $message,
				    				'ordre' => $ordre,
				    				))
						->where($this->tableid, $idmessage)
						->update($this->table);
	}


	/**
	* Supprime un message par son Id
	* @param int  $id	id du message
	* @return bool		Le résultat de la requête
	*/
	public function delete($id)
	{
		return $this->db->where($this->tableid, $id)
						->delete($this->table);
	}
	

	/**
	* Récupération du Max ordre
	* @param int  $id	id de la chaine
	* @return int ordre max du message de la chaine
	*/
	public function getMaxOrdre($id)
	{
		return $this->db->select_max('ordre')
						->from($this->table)
						->where(array('idchaine' => $id))
						->get()
						->result();

	}

	/**
	* Changer l'ordre d'une page
	* @param int  $id	id du message
	* @param int  $ordre ordre du message
	*/
	public function setOrdre($id,$ordre)
	{
		$data = array('ordre' => $ordre);

		return $this->db->where($this->tableid, $id)
						->update($this->table, $data);
	}

}
?>