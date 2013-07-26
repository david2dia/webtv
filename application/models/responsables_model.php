<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Responsables_model extends CI_Model
{
	private $table = 'responsables';
	private $tableid = 'idresponsable';

	/**
	* Récupération des responsables
	* @return tableau de responsables
	*/
	public function getAll()
	{
	return $this->db->select('*')
						->from($this->table)
						->get()
						->result();
	}
	
	/**
	 *	Ajout d'un Responsable
	 *	
	 *	@param string  $nom		nom du responsable
	 *	@param string  $prenom 	prenom du responsable
	 *	@param string  $mail 	mail du responsable
	 */
	public function add($nom, $prenom, $mail)
	{
		return $this->db->set(array('nom' => $nom,
				    				'prenom' => $prenom,
				    				'mail' => $mail,
				    				))
						->insert($this->table);
	}


	/**
	* Supprime un responsable par son Id
	* @param int  $id	id de la chaine
	* @return bool		Le résultat de la requête
	*/
	public function delete($id)
	{
		return $this->db->where($this->tableid, $id)
						->delete($this->table);
	}

}


?>