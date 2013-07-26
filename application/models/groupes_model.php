<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groupes_model extends CI_Model
{
	private $table = 'groupes';
	private $tableid = 'idgroupe';

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
	return $this->db->select('*')
						->from($this->table)
						->order_by("nom", "asc")
						->get()
						->result();
	}

	/**
	* Récupération des groupes
	* @return tableau de groupes
	*/
	public function getAllParent()
	{
	return $this->db->select('*')
						->from($this->table)
						->where(array('parent' => NULL))
						->get()
						->result();
	}


	/**
	* SPECIFIQUE PSQL
	* Récupération des groupes
	* @return tableau de groupes
	*/
	public function getParents($id)
	{
	$sql = "WITH RECURSIVE parents(idgroupe, nom, parent) AS (
        SELECT idgroupe, nom, parent FROM groupes WHERE idgroupe = ?
        UNION
        SELECT fs.idgroupe, fs.nom, fs.parent FROM groupes AS fs, parents
        WHERE parents.parent = fs.idgroupe)
        SELECT * FROM parents";
	$query = $this->db->query($sql, array($id));
	$queryre[0] = $query->result();
	$queryre[1] = $query->num_rows();
	return $queryre;
	}

	/**
	* SPECIFIQUE PSQL
	* Récupération des groupes
	* @return tableau de groupes
	*/
	public function getParentsId($id)
	{
	$sql = "WITH RECURSIVE parents(idgroupe, nom, parent) AS (
        SELECT idgroupe, nom, parent FROM groupes WHERE idgroupe = ?
        UNION
        SELECT fs.idgroupe, fs.nom, fs.parent FROM groupes AS fs, parents
        WHERE parents.parent = fs.idgroupe)
        SELECT idgroupe FROM parents";
	$query = $this->db->query($sql, array($id));
	return $query->result();
	}

	/**
	* SPECIFIQUE PSQL
	* Récupération des groupes
	* @return tableau de groupes
	*/
	public function getDescendants($id)
	{
	$sql = "WITH RECURSIVE Descendants AS (
		SELECT g.* FROM groupes g WHERE g.idgroupe = ? 
		UNION ALL
		SELECT g.* FROM groupes g 
		INNER JOIN Descendants H ON H.idgroupe = g.parent  
	)  	SELECT * FROM Descendants d";
	$query = $this->db->query($sql, array($id));
	$queryre[0] = $query->result();
	$queryre[1] = $query->num_rows();
	return $queryre;
	}

	/**
	* Récupération des groupes
	* @return tableau de groupes
	*/
	public function getchild($id)
	{
	return $this->db->select('*')
						->from($this->table)
						->where(array('parent' => $id))
						->get()
						->result();
	}

	/**
	* SPECIFIQUE PSQL
	* Récupération des groupes
	* @return tableau de groupes
	*/
	public function nbDescendants($id)
	{
	$sql = "WITH RECURSIVE Descendants AS (
	 SELECT g.* FROM groupes g where g.idgroupe = ? 
	 UNION ALL
	 SELECT g.* FROM groupes g 
	 INNER JOIN Descendants H ON H.idgroupe = g.parent  
	)  SELECT * FROM Descendants d";
	$query = $this->db->query($sql, array($id));
	return $query->num_rows();
	}

	/**
	 *	Ajout d'un groupe
	 *	
	 *	@param string  $nom				nom du groupe
	 *	@param string  $parent			id du parent
	 *	@param string  $description		description
	 *	@param string  $logo			url du logo
	 */
	public function add($nom, $parent, $description, $logo)
	{
		if ($logo =='') $logo = NULL;
		if ($description=='') $description = NULL;
		if ($parent=='NULL') $parent = NULL;
		return $this->db->set(array('nom' => $nom,
									'parent' => $parent,
				    				'description' => $description,
				    				'logo' => $logo,
				    				))
						->insert($this->table);
	}

	/**
	 *	Update groupe
	 *	
	 *	@param string  $nom				nom du groupe
	 *	@param string  $parent			id du parent
	 *	@param string  $description		description
	 *	@param string  $logo			url du logo
	 */
	public function update($idgroupe, $nom, $parent, $description, $logo)
	{
		if ($logo =='') $logo = NULL;
		if ($parent=='NULL') $parent = NULL;
		if ($description=='') $description = NULL;
		return $this->db->set(array('nom' => $nom,
				    				'parent' => $parent,
				    				'description' => $description,
				    				'logo' => $logo,
				    				))
						->where($this->tableid, $idgroupe)
						->update($this->table);
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