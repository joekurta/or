<?php
	error_reporting (E_ALL);
	
	function getFirstElementByTagName ($node, $elementName)
	{
		return $node->getElementsByTagName($elementName)->item(0);
	}
	function getWebsite($restoran)
	{
		$pom=getFirstElementByTagName($restoran,'id')->nodeValue;
		$data=file_get_contents('http://graph.facebook.com/'.$pom);
		$data=json_decode($data);
		if (!empty($data->website)) return $website=$data->website;
		else return '';
	}
	function showPicture($pom)
	{
			$picture = file_get_contents('http://graph.facebook.com/'.$pom.'?fields=picture');
			$picture = json_decode($picture);
			echo '<img src="'.$picture->picture->data->url.'" alt="profilka" height="50" width="50">';
	}
	function printFacebookAddress($pom)
	{
		$adresaFace=file_get_contents('http://graph.facebook.com/'.$pom.'?fields=location');
		$adresaFace=json_decode($adresaFace);
		if (!empty($adresaFace->location->street)) echo $adresaFace->location->street.', ';
		if (!empty($adresaFace->location->city)) echo $adresaFace->location->city;
		return $adresaFace;
	}
	function getSirina($adresaFace)
		{
		if (!empty($adresaFace->location->street)) $koordinateUpit=$adresaFace->location->street;
		if (!empty($adresaFace->location->city)) $koordinateUpit=$koordinateUpit.' '.$adresaFace->location->city;
		if (!empty($adresaFace->location->country)) $koordinateUpit=$koordinateUpit.' '.$adresaFace->location->country;
		if (!empty($koordinateUpit)) 
		{
			$koordinateUpit=urlencode($koordinateUpit);
			$koordinateUpit='http://open.mapquestapi.com/nominatim/v1/search?q='.$koordinateUpit.'&format=xml';
			$koordinateUpit=simplexml_load_file($koordinateUpit);
			if (!isset($koordinateUpit->place)) 
			{
				if (!empty($adresaFace->location->city)) $koordinateUpit=$adresaFace->location->city;
				$koordinateUpit='http://open.mapquestapi.com/nominatim/v1/search?q='.$koordinateUpit.'&format=xml';
				$koordinateUpit=simplexml_load_file($koordinateUpit);
			}
			if (!isset($koordinateUpit->place)) 
			{
				if (!empty($adresaFace->location->street)) $koordinateUpit=substr($adresaFace->location->street,11,19);
				$koordinateUpit='http://open.mapquestapi.com/nominatim/v1/search?q='.$koordinateUpit.'&format=xml';
				$koordinateUpit=simplexml_load_file($koordinateUpit);
			}
			if (isset($koordinateUpit->place)) return $koordinateUpit->place['lat'];
			if (isset($koordinateUpit->place)) echo 'lon=' .$koordinateUpit->place['lon'];
		}
	}
	function getDuzina($adresaFace)
	{
		if (!empty($adresaFace->location->street)) $koordinateUpit=$adresaFace->location->street;
		if (!empty($adresaFace->location->city)) $koordinateUpit=$koordinateUpit.' '.$adresaFace->location->city;
		if (!empty($adresaFace->location->country)) $koordinateUpit=$koordinateUpit.' '.$adresaFace->location->country;
		if (!empty($koordinateUpit)) 
		{
			$koordinateUpit=urlencode($koordinateUpit);
			$koordinateUpit='http://open.mapquestapi.com/nominatim/v1/search?q='.$koordinateUpit.'&format=xml';
			$koordinateUpit=simplexml_load_file($koordinateUpit);
			if (!isset($koordinateUpit->place)) 
			{
				if (!empty($adresaFace->location->city)) $koordinateUpit=$adresaFace->location->city;
				$koordinateUpit='http://open.mapquestapi.com/nominatim/v1/search?q='.$koordinateUpit.'&format=xml';
				$koordinateUpit=simplexml_load_file($koordinateUpit);
			}
			if (!isset($koordinateUpit->place)) 
			{
				if (!empty($adresaFace->location->street)) $koordinateUpit=substr($adresaFace->location->street,11,19);
				$koordinateUpit='http://open.mapquestapi.com/nominatim/v1/search?q='.$koordinateUpit.'&format=xml';
				$koordinateUpit=simplexml_load_file($koordinateUpit);
			}
			if (isset($koordinateUpit->place)) return $koordinateUpit->place['lon'];
		}
	}
	function printKoordinate($adresaFace)
	{
		if (!empty($adresaFace->location->street)) $koordinateUpit=$adresaFace->location->street;
		if (!empty($adresaFace->location->city)) $koordinateUpit=$koordinateUpit.' '.$adresaFace->location->city;
		if (!empty($adresaFace->location->country)) $koordinateUpit=$koordinateUpit.' '.$adresaFace->location->country;
		if (!empty($koordinateUpit)) 
		{
			$koordinateUpit=urlencode($koordinateUpit);
			$koordinateUpit='http://open.mapquestapi.com/nominatim/v1/search?q='.$koordinateUpit.'&format=xml';
			$koordinateUpit=simplexml_load_file($koordinateUpit);
			if (!isset($koordinateUpit->place)) 
			{
				if (!empty($adresaFace->location->city)) $koordinateUpit=$adresaFace->location->city;
				$koordinateUpit='http://open.mapquestapi.com/nominatim/v1/search?q='.$koordinateUpit.'&format=xml';
				$koordinateUpit=simplexml_load_file($koordinateUpit);
			}
			if (!isset($koordinateUpit->place)) 
			{
				if (!empty($adresaFace->location->street)) $koordinateUpit=substr($adresaFace->location->street,11,19);
				$koordinateUpit='http://open.mapquestapi.com/nominatim/v1/search?q='.$koordinateUpit.'&format=xml';
				$koordinateUpit=simplexml_load_file($koordinateUpit);
			}
			if (isset($koordinateUpit->place)) echo 'lat=' .$koordinateUpit->place['lat'].'<br/>';
			if (isset($koordinateUpit->place)) echo 'lon=' .$koordinateUpit->place['lon'];
		}
	}
	function generirajUpit ()
	{
		$listaUpit = array();
		
		if (!empty($_REQUEST['naziv']))
		{
			$listaUpit[] = 'contains(' . toUpper ('naziv') . ', "' . mb_strToUpper($_REQUEST['naziv'],'UTF-8') . '")';
		}
		if (!empty($_REQUEST['vise']) && ($_REQUEST['vise']=='da'))
		{
			$listaUpit[] = '@vise="' . $_REQUEST['vise'] . '"';
		}
		if (!empty($_REQUEST['klasa']))
		{
			$klasaUpit = array();
			
			foreach ($_REQUEST['klasa'] as $klasa)
			{
				$klasaUpit[] = '@klasa="' . $klasa . '"';
			}
			
			if (!empty($klasaUpit))
			{
				$listaUpit[] = '(' . implode(' or ', $klasaUpit) . ')';
			}
		}
		
		$telefonUpit = array();
		
		if (!empty($_REQUEST['pozivni']))
		{
			$telefonUpit[] = '@pozivni="' . $_REQUEST['pozivni'] . '"';
		}
		if (!empty($_REQUEST['broj']))
		{
			$telefonUpit[] = 'contains(broj, "' . $_REQUEST['broj'] . '")';
		}
		if (!empty($telefonUpit))
		{
			$listaUpit[] = 'telefon[' . implode(' and ', $telefonUpit) . ']';
		}
		
		$adresaUpit = array();
		
		if (!empty($_REQUEST['ulica']))
		{
			$adresaUpit[] = 'contains(' . toUpper('ulica') . ', "' . mb_strToUpper($_REQUEST['ulica'],'UTF-8') . '")';
		}
		if (!empty($_REQUEST['kucnibr']))
		{
			$adresaUpit[] = 'contains(kucnibr, "' . $_REQUEST['kucnibr'] . '")';
		}
		if (!empty($_REQUEST['mjesto']))
		{
			$adresaUpit[] = 'contains(' . toUpper('mjesto') . ', "' . mb_strToUpper($_REQUEST['mjesto'], 'UTF-8') . '")';
		}
		if (!empty($_REQUEST['postbr']))
		{
			$adresaUpit[] = 'mjesto[contains(@postbr, "' . $_REQUEST['postbr'] . '")]';
		}
		if (!empty($adresaUpit))
		{
			$listaUpit[] = 'adresa[' . implode(' and ', $adresaUpit) . ']';
		}
		
		if (!empty($_REQUEST['email']))
		{
			$listaUpit[] = 'email[contains('. toUpper('.'). ', "'. mb_strToUpper($_REQUEST['email'],'UTF-8') . '")]';
		}
		
		$jelovnikUpit = array();
		
		if (!empty($_REQUEST['hladno_pred']))
		{
			$jelovnikUpit[] = 'contains(' . toUpper('hladno_pred') . ', "' . mb_strToUpper($_REQUEST['hladno_pred'],'UTF-8') . '")';
		}
		if (!empty($_REQUEST['juha']))
		{
			$jelovnikUpit[] = 'contains(' . toUpper('juha') . ', "' . mb_strToUpper($_REQUEST['juha'],'UTF-8') . '")';
		}
		if (!empty($_REQUEST['toplo_pred']))
		{
			$jelovnikUpit[] = 'contains(' . toUpper('toplo_pred') . ', "' . mb_strToUpper($_REQUEST['toplo_pred'],'UTF-8') . '")';
		}
		if (!empty($_REQUEST['gl_jelo']))
		{
			$jelovnikUpit[] = 'contains(' . toUpper('gl_jelo') . ', "' . mb_strToUpper($_REQUEST['gl_jelo'],'UTF-8') . '")';
		}
		if (!empty($_REQUEST['prilog']))
		{
			$jelovnikUpit[] = 'contains(' . toUpper('prilog') . ', "' . mb_strToUpper($_REQUEST['prilog'],'UTF-8') . '")';
		}
		if (!empty($_REQUEST['salata']))
		{
			$jelovnikUpit[] = 'contains(' . toUpper('salata') . ', "' . mb_strToUpper($_REQUEST['salata'],'UTF-8') . '")';
		}
		if (!empty($_REQUEST['desert']))
		{
			$jelovnikUpit[] = 'contains(' . toUpper('desert') . ', "' . mb_strToUpper($_REQUEST['desert'],'UTF-8') . '")';
		}
		if (!empty($jelovnikUpit))
		{
			$listaUpit[] = 'jelovnik[' . implode(' and ', $jelovnikUpit) . ']';
		}
		
		$strUpit = implode(' and ', $listaUpit);
		
		if (empty($strUpit))
		{
			return '/ponuda_restorana/restoran';
		}
		else
		{
			return '/ponuda_restorana/restoran[' . $strUpit . ']';
		}
		

	}
	function toUpper($string)
	{
	return	"translate(" . $string . ", 'abcdefghijklmnopqrstuvwxyzčćšžđ.@', 'ABCDEFGHIJKLMNOPQRSTUVWXYZČĆŠŽĐ.@')";
	}
?>