<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Titre Url Helper
 * Return le titre d'une url
 *
 * @author 		David Dias <david.dias@oxylane.com>
 * @copyright 	Copyright (c) 2013, David Dias, Oxylane
 * @version 	1.0.0
 */

if ( ! function_exists('get_file_title'))
{
	function get_file_title($file)
	{
		ini_set('allow_url_fopen', true);
		$opts = array('http' => array('proxy' => 'tcp://gateway.zscaler.net:80', 'request_fulluri' => true));
		$context = stream_context_create($opts);
		$cont = file_get_contents($file, false, $context);
		if ($cont === false) 
		{ 
    		return "No Titre";
		} else { 
			if(preg_match( "/<title>(.*)<\/title>/i", $cont, $match )) return strip_tags($match[0]);
			else return "No Titre";
		}
	}
}

/* End of file  titreUrl_helper.php */

?>