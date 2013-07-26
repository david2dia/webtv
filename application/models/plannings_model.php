<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plannings_model extends CI_Model
{
	private $table = 'plannings';
	private $tableid = 'idplanning';


	/**
	* Récupération des pages d'une chaine
	* @return tableau de chaines
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
	* Récupération du dernier enregistrement
	* @return tableau de chaines
	*/
	public function getLast()
	{
		return $this->db->select($this->tableid)
						->from($this->table)
						->order_by($this->tableid, "DESC")
						->limit(1)
						->get()
						->result();
	}

	/**
	 *	Ajout d'une plage horaire
	 *	
	 *	@param DataTime     $date_debut 	date d'affichage de la page
	 *	@param DataTime     $date_fin 	date d'affichage de la page
	 *	@param TimesTamp    $temps_debut 	date d'affichage de la page
	 *	@param TimesTamp    $temps_fin 	date d'affichage de la page
	 */

	
	public function add($date_debut, $date_fin, $temps_debut, $temps_fin, $hebdo)
	{
		return $this->db->set(array('datedebut' => $date_debut,
				    				'datefin' => $date_fin,
				    				'timedebut' => $temps_debut,
				    				'timefin' => $temps_fin,
				    				'hebdo' => $hebdo,
				    				))
						->set($this->tableid, 'Default', false)
						->insert($this->table);
					/*	->insert_id($this->table);*/
	}

	public function update($idplanning, $date_debut, $date_fin, $temps_debut, $temps_fin)
	{

		return $this->db->set(array('datedebut' => $date_debut,
				    				'datefin' => $date_fin,
				    				'timedebut' => $temps_debut,
				    				'timefin' => $temps_fin,
				    				))
						->where($this->tableid, $idplanning)
						->update($this->table);
	}

	/**
	* Supprime une plage horaire par son Id
	* @param int  $id	id de la plage horaire
	* @return bool		Le résultat de la requête
	*/
	public function delete($id)
	{
		return $this->db->where($this->tableid, $id)
						->delete($this->table);
	}

}

?>