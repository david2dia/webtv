<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('css_url'))
{
	function css_url($nom)
	{
		return base_url() . 'assets/css/' . $nom . '.css';
	}
}

if ( ! function_exists('tagcss'))
{
	function tagcss($nom, $media='screen')
	{
		return '<link rel="stylesheet" type="text/css" media="'. $media .'" href="' . css_url($nom) . '" />';
	}
}

if ( ! function_exists('less_url'))
{
	function less_url($nom)
	{
		return base_url() . 'assets/less/' . $nom . '.less';
	}
}

if ( ! function_exists('js_url'))
{
	function js_url($nom)
	{
		return base_url() . 'assets/js/' . $nom . '.js';
	}
}

if ( ! function_exists('tagjs'))
{
	function tagjs($nom)
	{
		return '<script type="text/javascript" src="' . js_url($nom) . '"></script>';
	}
}

if ( ! function_exists('img_url'))
{
	function img_url($nom)
	{
		return base_url(). 'assets/img/' .$nom;
	}
}

if ( ! function_exists('tagimg'))
{
	function tagimg($nom, $alt = '', $x = '', $y = '')
	{
		if ($x and $y != null) return '<img src="' . img_url($nom) . '" alt="' . $alt . '" width="' . $x . '" height="' . $y . '" />';
		else return '<img src="' . img_url($nom) . '" alt="' . $alt . '" />';
	}
}


/* End of file assets_helper.php */

?>