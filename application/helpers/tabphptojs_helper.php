<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Tab php to Js
 * Return un tab js
 *
 * @author      David D
 * @copyright   Copyright (c) 2013, David D, Oxylane
 * @version 	1.0.0
 */

if ( ! function_exists('php2js'))
{
function php2js($var) {
    if (is_array($var)) {
        $res = "[";
        $array = array();
        foreach ($var as $a_var) {
            $array[] = php2js($a_var);
        }
        return "[" . join(",", $array) . "]";
    }
    elseif (is_bool($var)) {
        return $var ? "true" : "false";
    }
    elseif (is_int($var) || is_integer($var) || is_double($var) || is_float($var)) {
        return $var;
    }
    elseif (is_string($var)) {
        return "\"" . addslashes(stripslashes($var)) . "\"";
    }
    // autres cas: objets, on ne les gère pas
    return FALSE;
}
}

/* End of file  titreUrl_helper.php */

?>