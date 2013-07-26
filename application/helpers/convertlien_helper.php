<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('detectUrl'))
{	
	/* 
		Fonction qui permet la detection de l'host de l'url.
		Elle renvois l'id et l'host de l'url pour les services :
		Youtube, Vimeo, Daylimotion, youku et Google Doc
	*/
		
	function detectUrl($url) {
		$parse = parse_url($url);
		$id = 0;
		//echo $url;
		if(isset($parse['host'])) {
			switch ($parse['host']) {
				case 'youtu.be':
				$info[0] = 'youtube';
				$info[1] = substr($parse['path'], 1);
				return $info;
				break;
				case 'www.youtube.com':
				$info[0] = 'youtube';
				if (isset($parse['query'])) {
					$parse2 = parse_str($parse['query'], $data);
					if (isset($data['v'])) {
						$info[1] = $data['v'];
						return $info;
					}
					else return $url;
				} else {
					$info[1] = substr($parse['path'], 7);
					return $info;
				}
				break;
				case 'vimeo.com':
				$info[0] = 'vimeo';
				$info[1] = substr($parse['path'], 1);
				break;
				case 'www.dailymotion.com':
				$info[0] = 'dailymotion';
				$info[1] = substr($parse['path'], 7);
				break;
				case 'v.youku.com':
				$info[0] = 'youku';
				$id = $parse['path'];
						$id = explode("/", $id);
						$id = explode(".", $id[2]);
						$info[1] = substr($id[0], 3);
				return $info;
				break;
				case 'docs.google.com':
				if (mb_eregi("presentation",$parse['path'])) {
					$info[0] = 'googleDocPres';
					if (isset($parse['query'])) {
						/*$parse2 = parse_str($parse['query'], $data);
						$info[1] = $data['id'];*/
						return $url;
					} else {
						$id = $parse['path'];
						$id = strstr($id,"d");
						$id = explode("/", $id);
						$info[1] = $id[1];
					}
				return $info;
				} else return $url;
				break;
				default:
				return $url;
				break;
			}
		} else return $url;
	}
}

if ( ! function_exists('formate'))
{	
	/* 
		Fonction qui formate l'url en fonction de l'host
		Elle renvois le lien de type partage des service (embed) pour :
		Youtube, Vimeo, Daylimotion et Google Doc gere l'autoload et l'hd
	*/
	function formate($hostori){
		if(is_array($hostori)) {
			$host = $hostori[0];
			$id = $hostori[1];
		} else {
			$formated_url[1] = 1;
			$formated_url[0] = $hostori;
			return $formated_url;
		}
		switch ($host) {
			case 'youtube':
			//echo "<br>Lien de type YOUTUBE<br>";
			$formated_url[1] = 2;
			$formated_url[0] = 'http://www.youtube.com/embed/' . $id . '?autoplay=1&amp;rel=0&amp;vq=hd720';
			break;
			case 'vimeo':
			//echo "<br>Lien de type VIMEO<br>";
			$formated_url[1] = 2;
			$formated_url[0] = 'http://player.vimeo.com/video/' . $id . '?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=1';
			break;
			case 'dailymotion':
			//echo "<br>Lien de type DAILYMOTION<br>";
			$formated_url[1] = 2;
			$formated_url[0] = 'http://www.dailymotion.com/embed/video/' . $id .'?autoPlay=1';
			break;
			case 'youku':
			//echo "<br>Lien de type YOUKU<br>";
			$formated_url[1] = 3;
			/*$formated_url[0] = 'http://player.youku.com/player.php/sid/' . $id . '/v.swf';*/
			$formated_url[0] = 'http://static.youku.com/v1.0.0312/v/swf/qplayer.swf?VideoIDS=' . $id .'&embedid=-&isAutoPlay=true&showAd=0';
			break;
			case 'googleDocPres':
			//echo "<br>Lien de type PRESENTATION GOOGLE DRIVE<br>";
			$formated_url[1] = 4;
			$formated_url[0] = 'https://docs.google.com/presentation/embed?id=' . $id .'&amp;start=true&amp;loop=false&amp;delayms=60000';
			break;
			default:
			$formated_url[1] = 1;
			$formated_url[0] = 'Invalide';
			break;
		}
		return $formated_url;
	}
}


if ( ! function_exists('getUrlPartage'))
{
	/* 
		Prend en argument un lien de type :
		Youtube, Vimeo, Daylimotion et Google Doc
		return son lien de partage de type embed.
	*/
	function getUrlPartage($url){
		return formate(detectUrl($url));
	}
}

?>