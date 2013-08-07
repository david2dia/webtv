<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chaines_model extends CI_Model
{
	private $table = 'chaines';
	private $tableid = 'idchaine';


	/**
	* Récupération des informations d'une chaine
	* @return tableau d'information
	*/
	public function get($id)
	{
		return $this->db->select('chaines.*, groupes.nom as groupe')
						->from($this->table)
						->join('groupes', 'groupes.idgroupe = chaines.idgroupe')
						->where(array($this->tableid => $id))
						->get()
						->result();
	}

	/**
	* Récupération des chaines
	* @return tableau de chaines
	*/
	public function getAll()
	{
		return $this->db->select('*')
						->from($this->table)
						->order_by("nom", "asc")
						->get()
						->result();
	}

	/**
	* Récupération des chaines du groupe
	* @return tableau de chaines
	*/
	public function getAllByGroupe($id)
	{
		return $this->db->select('*')
						->from($this->table)
						->where(array('idgroupe' => $id))
						->order_by("nom", "asc")
						->get()
						->result();
	}

	/**
	* Récupération des chaines du groupe
	* @return tableau de chaines
	*/
	public function getAllByMultiGroupe($id)
	{
	foreach($id as $parent) $rep[] = $parent->idgroupe;
		return $this->db->select($this->tableid)
						->from($this->table)
						->where_in('idgroupe',$rep)
						->get()
						->result();
	}


	/**
	* Récupération des responsable de chaines
	* @return tableau de responsables
	*/
	public function getAllResponsables()
	{
		return $this->db->select('responsable')
						->group_by(array("responsable"))
						->from($this->table)
						->order_by("responsable", "asc")
						->get()
						->result();	
	}


	/**
	 *	Ajout d'une Chaine
	 *	
	 *	@param string  $nom				nom de la chaine
	  *	@param int  $responsable 		id du groupe
	 *	@param string  $description		description de la chaine
	  *	@param string  $responsable 	url du logo
	 *	@param string  $responsable 	nom du responsable
	  *	@param bool  $responsable 		logo afficher
	 */
	public function add($nom, $idgroupe, $description, $logo, $responsable, $activelogo, $activeband)
	{
		if ($logo =='') $logo = NULL;
		if ($description=='') $description = NULL;
		if ($idgroupe=='NULL') $idgroupe = NULL;
		return $this->db->set(array('nom' => $nom,
									'idgroupe' => $idgroupe,
				    				'description' => $description,
				    				'logo' => $logo,
				    				'responsable' => $responsable,
				    				'activelogo' => $activelogo,
				    				'activelogo' => $activeband,
				    				))
						->insert($this->table);
	}

	/**
	* Verifie q'une chaine existe
	* @param int  $id	id de la chaine
	* @return int nombres de chaine
	*/
	public function verifChaine($id)
	{
		return $this->db->select('idchaine')
						->from($this->table)
						->where(array('idchaine' => $id))
						->count_all_results();
	}


	public function update($idchaine, $nom, $idgroupe, $description, $logo, $responsable, $activelogo, $activeband)
	{
		if ($logo =='') $logo = NULL;
		if ($description=='') $description = NULL;
		if ($idgroupe=='NULL') $idgroupe = NULL;
		return $this->db->set(array('nom' => $nom,
									'idgroupe' => $idgroupe,
				    				'description' => $description,
				    				'logo' => $logo,
				    				'responsable' => $responsable,
				    				'activelogo' => $activelogo,
				    				'activeband' => $activeband,
				    				))
						->where($this->tableid, $idchaine)
						->update($this->table);
	}


	/**
	* Supprime une page par son Id
	* @param int  $id	id de la chaine
	* @return bool		Le résultat de la requête
	*/
	public function delete($id)
	{
		return $this->db->where($this->tableid, $id)
						->delete($this->table);
	}


	/**
	* Récupération le nombre de chaine
	* @return int nombres de pages
	*/
	public function getNb()
	{
		return $this->db->select('*')
						->from($this->table)
						->count_all_results();
	}

}


?>
