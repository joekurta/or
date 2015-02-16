<?php
	
	include ('funkcije.php');
  
	error_reporting (E_ALL);

	$dom = new DOMDocument();
	
	$dom->load('podaci.xml');

	$xp = new DOMXPath($dom);

	$upit = generirajUpit();
	$rezultat = $xp->query($upit);

?>
	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
	<title>Restorani u Zagorju</title>
			<link rel="stylesheet" type="text/css" href="dizajn.css"/>
			<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine"/>
			<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato"/>
			<meta name="keywords" content="Restorani, Zagorje, Ugostiteljsvo, Hrana"/>
			<meta name="description" content="Ponuda svih restorana u Zagorju na jednom mjestu"/>
			<meta name="author" content="Martin Kurtoić"/>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<script type="text/javascript" src="detalji.js"></script>
			<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.css" />
			<script src="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.js"></script>
		</head>
		<body class="pozadina">
			<div class="container">
				<div class="header">
					<a href="index.html"><img src="vrhslika.png" class="naslovna" alt="Zagorje logo" width="180" height="180"/></a>
					<h1>Ponuda restorana u Zagorju</h1>
				</div>
		<div class="menu">
			<a class="meni" href="index.html">Početna stranica</a><br/>
			<a class="meni" href="obrazac.html">Pretraživanje</a><br/>
			<a class="meni" href="podaci.xml">Pregled podataka</a><br/>
			<a class="meni" href="http://www.fer.unizg.hr/rasip">RASIP</a><br/>
			<a class="meni" href="http://www.fer.unizg.hr">FER</a><br/>
			<a class="meni" href="mailto:martin.kurtoic@fer.hr?Subject=Restorani%20web">e-mail</a>
			<br/><br/>
			<div class="detalji" id="detalji"></div>
		</div>
		<div class="content">
			<h2>Rezultati pretraživanja</h2>
			<table class="tekst" summary="forma">
				<thead>
					<tr class="tablica">
						<td><center><b>Profilka</b></center></td>
						<td><center><b>Restoran</b></center></td>
						<td><center><b>Telefon</b></center></td>
						<!--<td><center><b>100+</b></center></td>-->
						<td><center><b>Adresa</b></center></td>
						<!--<td><center><b>Koordinate</b></center></td>-->
						<td><center><b>Glavno jelo</b></center></td>
						<!--<td><center><b>Klasa</b></center></td>-->
						<!--<td><center><b>E-mail</b></center></td>-->
						<td><center><b>Akcija</b></center></td>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($rezultat as $restoran)
					{
					$pom=getFirstElementByTagName($restoran,'id')->nodeValue;
					$website=getWebsite($restoran);
					if (!empty($website) && substr($website,0,1)!=='h')
					{
						$website='http://'.$website;
					}
					?>
					<tr onmouseover="promijeniBoju(this)" onmouseout="vratiBoju(this)">
						<td><?php 
								showPicture($pom);
							?>
						</td>
						<td><?php echo getFirstElementByTagName($restoran, 'naziv')->nodeValue;?></td>	
						<td><?php
								foreach ($restoran->getElementsByTagName('telefon') as $telefon)
								{
									echo $telefon->getAttribute('pozivni');
									echo ' ';
									echo getFirstElementByTagName($telefon, 'broj')->nodeValue." ";
									echo '<br/>';
								}
							?>
						</td>
						<!--<td><center><?php echo $restoran->getAttribute('vise'); ?></center></td>-->
						<td>
							<?php
								$adresaFace=printFacebookAddress($pom);
								//$adresa = getFirstElementByTagName($restoran, 'adresa');
								//if (!empty($adresa))
								//{
								//	echo getFirstElementByTagName($adresa, 'mjesto')->getAttribute('postbr') . ' ';
								//	echo getFirstElementByTagName($adresa, 'mjesto')->nodeValue;;
								//}
							?>
						</td>
						<!--<td>
							<?php
								$sirina=getSirina($adresaFace);
								$duzina=getDuzina($adresaFace);
								printKoordinate($adresaFace);
							?>
						</td>-->
						<td>
							<?php
								$jelovnik = getFirstElementByTagName($restoran, 'jelovnik');
								if (!empty($jelovnik))
								{
									echo getFirstElementByTagName($jelovnik, 'gl_jelo')->nodeValue;
								}
							?>
						</td>
						<!--<td><?php echo $restoran->getAttribute('klasa'); ?></td>-->
						<!--<td><?php 
								foreach ($email=$restoran->getElementsByTagName('email') as $email)
								{
								if (!empty($email))
									{
										echo '<a class="tekst" style="left:0px;" href=mailto:';
										echo $email->nodeValue;
										echo '>';
										echo $email->nodeValue;
										echo '</a>';
										echo '<br/>';
									}
								}
							?>
						</td>-->
						<td>
							<a href="#" class="tekst" style="left:0px;" onclick="loadXMLDoc('<?php echo getFirstElementByTagName($restoran, 'naziv')->nodeValue; ?>'); generirajMapu(mapContainer,'<?php echo $sirina;?>','<?php echo $duzina;?>','<?php echo getFirstElementByTagName($restoran, 'naziv')->nodeValue; ?>','<?php echo $website;?>'); return false;">Detalji</a>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table><br/>
		<center><div class="mapContainer" id="mapContainer"></div></center>
		</div>
		<div class="footer">
			Autor: Martin Kurtoić<br/>
			Fakultet elektrotehnike i računarstva, Zagreb<br/>
			Copyright © 2014
		</div>
	</div>
</body>
</html>							