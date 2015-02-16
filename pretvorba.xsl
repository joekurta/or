<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="xml" indent="yes"
				doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"
				doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN" />
	<xsl:template match="/">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<title>Restorani u Zagorju</title>
			<link rel="stylesheet" type="text/css" href="dizajn.css"/>
			<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine"/>
			<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato"/>
			<meta name="keywords" content="Restorani, Zagorje, Ugostiteljsvo, Hrana"/>
			<meta name="description" content="Ponuda svih restorana u Zagorju na jednom mjestu"/>
			<meta name="author" content="Martin Kurtoić"/>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
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
			<a href="podaci.xml" class="meni current">Pregled podataka</a><br/>
			<a class="meni" href="http://www.fer.unizg.hr/rasip">RASIP</a><br/>
			<a class="meni" href="http://www.fer.unizg.hr">FER</a><br/>
			<a class="meni" href="mailto:martin.kurtoic@fer.hr?Subject=Restorani%20web">e-mail</a>
		</div>
		<div class="content">
			<h2>Pregled podataka</h2>
			<table class="tekst" summary="forma">
				<thead>
					<tr class="tablica">
						<td><center><b>Restoran</b></center></td>
						<td><center><b>Telefon</b></center></td>
						<td><center><b>100+</b></center></td>
						<td><center><b>Mjesto</b></center></td>
						<td><center><b>Glavno jelo</b></center></td>
						<td><center><b>Klasa</b></center></td>
						<td><center><b>E-mail</b></center></td>
					</tr>
				</thead>
				<tbody>
					<xsl:for-each select="/ponuda_restorana/restoran">
					<tr>
						<td>
							<xsl:value-of select="naziv"/>
						</td>
						<td>
							<xsl:for-each select="telefon">
								<xsl:value-of select="@pozivni" />
								<xsl:text> </xsl:text>
							    <xsl:value-of select="broj" />
								  <xsl:if test="not(position()=last())">
										<br />
								  </xsl:if>
							</xsl:for-each>
						</td>
						<td>
							<center><xsl:value-of select="@vise"/></center>
						</td>
						<td>
							<xsl:if test="string(adresa/mjesto)">
								<xsl:value-of select="adresa/mjesto/@postbr" />
								<xsl:text> </xsl:text>
								<xsl:value-of select="adresa/mjesto" />
							</xsl:if>
						</td>
						<td>
							<xsl:for-each select="jelovnik">
								<xsl:value-of select="gl_jelo"/>
							</xsl:for-each>
						</td>
						<td>
							<xsl:value-of select="@klasa"/>
						</td>
						<td>
							<xsl:for-each select="email">
							<a  class="tekst" href="mailto:{email}">
								<xsl:value-of select="current()"/>
								<xsl:if test="not(position()=last())">
										<br />
								</xsl:if>
							</a>
							</xsl:for-each>
						</td>							
					</tr>
					</xsl:for-each>
				</tbody>
			</table>
		</div>
		<div class="footer">
			Autor: Martin Kurtoić<br/>
			Fakultet elektrotehnike i računarstva, Zagreb<br/>
			Copyright © 2014
		</div>
	</div>
</body>
</html>
</xsl:template>
</xsl:stylesheet>