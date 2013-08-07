<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logs_model extends CI_Model
{
	private $table = 'logs';
	private $tableid = 'idlogs';

	/**
	* Récupération un log
	* @return tableau de log
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
	* Récupération des logs
	* @return tableau de logs
	*/
	public function getAll()
	{
	$date = date('Y-m-d', strtotime('-'.TIMELOG.'days'));
	return $this->db->select('*')
						->from($this->table)
						->where('date >', $date)
						->order_by($this->tableid, "desc")
						->get()
						->result();
	}


	/**
	 *	Ajout d'un log utilise le System FED Oxylane
	 *	
	 */
	public function add($action, $type, $detail)
	{
		$as = new SimpleSAML_Auth_Simple('Oxylane-sp');
		$attributes = $as->getAttributes();
		return $this->db->set(array('action' => $action,
									'type' => $type,
									'feduid' => $attributes['uid'][0],
									'nom' => $attributes['cn'][0],
									'mail' => $attributes['mail'][0],
									'detail' => $detail
				    				))
						->set('date', 'NOW()', false)
						->insert($this->table);
	}


	/**
	 *	Ajout d'un log utilise sans FED
	 *	
	 */
	public function addManuel($action, $type, $detail, $uid, $nom, $mail)
	{
		$as = new SimpleSAML_Auth_Simple('Oxylane-sp');
		$attributes = $as->getAttributes();
		return $this->db->set(array('action' => $action,
									'type' => $type,
									'feduid' => $uid,
									'nom' => $nom,
									'mail' => $mail,
									'detail' => $detail
				    				))
						->set('date', 'NOW()', false)
						->insert($this->table);
	}

}

?>