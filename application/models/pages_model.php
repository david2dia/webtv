<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages_model extends CI_Model
{
	private $table = 'pages';
	private $tableid = 'idpage';


	/**
	* Récupération des pages d'une chaine
	* @return tableau de chaines
	*/
	public function get($id)
	{
	return $this->db->select('*')
					->from($this->table)
					->join('plannings', 'plannings.idplanning = pages.idplanning')
					->where(array($this->tableid => $id))
					->get()
					->result();	
	}

	/**
	* Récupération des pages d'une chaine
	* @return tableau de chaines
	*/
	public function getAllByChaine($id)
	{
	return $this->db->select('*')
					->from($this->table)
					->join('plannings', 'plannings.idplanning = pages.idplanning')
					->where(array('idchaine' => $id))
					->order_by("ordre", "asc")
					->get()
					->result();	
	}

	/**
	* Récupération des pages d'une chaine si date et heure valide
	* @return tableau de chaines
	*/
	public function getAllByChaineIsValide($id)
	{
	return $this->db->select('*')
					->from($this->table)
					->join('plannings', 'plannings.idplanning = pages.idplanning')
					->where(array(
						'idchaine' => $id,
						'datedebut <=' => mdate("%Y-%m-%d", time()),
						'datefin >=' => mdate("%Y-%m-%d", time()), 
						'timedebut <=' => mdate("%H:%i:%s", time()),
						'timefin >=' => mdate("%H:%i:%s", time())
					))
					->order_by("ordre", "asc")
					->get()
					->result();	
	}


	/**
	* Récupération des pages valide
	* @return tableau de chaines
	*/
	public function getAll()
	{
	return $this->db->select('*')
					->from($this->table)
					->order_by("ordre", "asc")
					->get()
					->result();
	}

	/**
	 *	Ajout d'une page
	 *	
	 *	@param string  $titre	titre de la page
	 *	@param string  $url 	l'url de la page
	 *	@param int     $temps 	temps d'affichage de la page
	 *	@param DataTime     $date_debut 	date d'affichage de la page
	 *	@param DataTime     $date_fin 	date d'affichage de la page
	 *	@param TimesTamp    $temps_debut 	date d'affichage de la page
	 *	@param TimesTamp    $temps_fin 	date d'affichage de la page
	 *	@param int     $chaines 	id de la chaine
	 *	@param int     $types 	id types de la page
	 *	@param boolean     $public la page est du domaine public
	 *	@return bool		Le résultat de la requête
	 */

	
	public function add($titre, $url, $temps, $date_debut, $date_fin, $temps_debut, $temps_fin, $hebdo, $chaine, $public)
	{
		$type = getUrlPartage($url);
		$url = $type[0];
		$type = $type[1];
		$ordre = $this->getMaxOrdre($chaine);
		$ordre = $ordre[0]->ordre;
		$ordre = $ordre+1;

		$this->plm->add($date_debut, $date_fin, $temps_debut, $temps_fin, $hebdo);
		$id = $this->plm->getLast();
		$id = $id[0]->idplanning;

		return $this->db->set(array('titre' => $titre,
				    				'url' => $url,
				    				'temps' => $temps,
				    				'ordre' => $ordre,
				    				'idplanning' => $id,
				    				'idchaine' => $chaine,
				    				'idtype' => $type,
				    				'public' => $public,
				    				))
						->set('idpage', 'Default', false)
						->set('datemodif', 'NOW()', false)
						->set('dateenr', 'NOW()', false)
						->insert($this->table);
	}

	public function addLite($url, $temps, $chaine, $public)
	{
		/** Vérifier les données */

		$titre = get_file_title($url);
		$type = getUrlPartage($url);
		$url = $type[0];
		$type = $type[1];
		$ordre = $this->getMaxOrdre($chaine);
		$ordre = $ordre[0]->ordre;
		$ordre = $ordre+1;

		return $this->db->set(array('titre' => $titre,
				    				'url' => $url,
				    				'temps' => $temps,
				    				'ordre' => $ordre,
				    				'idtype' => $type,
				    				'idchaine' => $chaine,
				    				'public' => $public,
				    				))
						->set('idpage', 'Default', false)
						->set('idplanning', 'Default', false)
						->set('datemodif', 'NOW()', false)
						->set('dateenr', 'NOW()', false)
						//->insert_id($this->table, $this->tableid);
						->insert($this->table);
	}


	public function update($idpage,$titre, $url, $temps, $date_debut, $date_fin, $temps_debut, $temps_fin, $idplanning, $chaine, $public)
	{
		if ($idplanning==1) {
			$this->plm->add($date_debut, $date_fin, $temps_debut, $temps_fin, NULL);
			$id = $this->plm->getLast();
			$id = $id[0]->idplanning;
		}else{
			$this->plm->update($idplanning,$date_debut, $date_fin, $temps_debut, $temps_fin, NULL);
			$id = $idplanning;
		}

		return $this->db->set(array('titre' => $titre,
				    				'url' => $url,
				    				'temps' => $temps,
				    				'idplanning' => $id,
				    				'idchaine' => $chaine,
				    				'public' => $public,
				    				))
						->set('datemodif', 'NOW()', false)
						->where($this->tableid, $idpage)
						->update($this->table);
	}

	/**
	* Supprime une page par son Id
	* @param int  $id	id de la page
	* @return bool		Le résultat de la requête
	*/
	public function delete($id)
	{
		return $this->db->where($this->tableid, $id)
						->delete($this->table);
	}


	/**
	* Récupération le nombre de page Actif de la chaine
	* @param int  $id	id de la chaine
	* @return int nombres de pages
	*/
	public function getNbLiens($id)
	{
		return $this->db->select('titre')
						->from($this->table)
						->join('plannings', 'plannings.idplanning = pages.idplanning')
						->where(array(
						'idchaine' => $id,
						'datedebut <=' => mdate("%Y-%m-%d", time()),
						'datefin >=' => mdate("%Y-%m-%d", time()), 
						'timedebut <=' => mdate("%H:%i:%s", time()),
						'timefin >=' => mdate("%H:%i:%s", time())
					))
						->count_all_results();
	}

	/**
	* Récupération du temps de la sequence de la chaine
	* @param int  $id	id de la chaine
	* @return int temps de la sequence
	*/
	public function getTempsSequence($id)
	{
		return $this->db->select_sum('temps')
						->from($this->table)
						->join('plannings', 'plannings.idplanning = pages.idplanning')
						->where(array(
						'idchaine' => $id,
						'datedebut <=' => mdate("%Y-%m-%d", time()),
						'datefin >=' => mdate("%Y-%m-%d", time()), 
						'timedebut <=' => mdate("%H:%i:%s", time()),
						'timefin >=' => mdate("%H:%i:%s", time())
					))
						->get()
						->result();
	}

	/**
	* Récupération du Max ordre
	* @param int  $id	id de la chaine
	* @return int ordre max des pages de la chaine
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
	* @param int  $id	id de la page
	* @param int  $ordre ordre de la page
	* @return int temps de la sequence
	*/
	public function setOrdre($id,$ordre)
	{
		$data = array('ordre' => $ordre);

		return $this->db->where($this->tableid, $id)
						->update($this->table, $data);
	}

}

?>