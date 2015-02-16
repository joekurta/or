<?php
	
	include ('funkcije.php');
  
	error_reporting (E_ALL);

	$dom = new DOMDocument();
	
	$dom->load('podaci.xml');

	$xp = new DOMXPath($dom);

	$upit = generirajUpit();
	$rezultat = $xp->query($upit);
	
	foreach ($rezultat as $restoran)
	{
		
		echo '<b>Detaljne informacije</b><br/><br/>';
		echo '<b>Restoran:</b> '. getFirstElementByTagName($restoran, 'naziv')->nodeValue.'<br/>';
		echo '<b>100+ mjesta:</b> '.$restoran->getAttribute('vise').'<br/>';
		echo '<b>Klasa:</b> '.$restoran->getAttribute('klasa').'<br/>';
								if (!empty(getFirstElementByTagName($restoran, 'email')->nodeValue))
								{
								foreach ($email=$restoran->getElementsByTagName('email') as $email)
								{
								if (!empty($email))
									{
										echo '<b>E-mail:</b> <a class="tekst" style="left:0px;" href=mailto:';
										echo $email->nodeValue;
										echo '>';
										echo $email->nodeValue;
										echo '</a>';
										echo '<br/>';
									}
								}
								}
								else echo '<b>E-mail:</b> <i>Nema podataka</i><br/>';					
	}
	sleep(1);
?>