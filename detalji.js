function promijeniBoju(moj_red_tablice) 
{
	moj_red_tablice.style.backgroundColor="#FFD873";
}
function vratiBoju(moj_red_tablice) 
{
	moj_red_tablice.style.backgroundColor="#FFFFFF";
}


	var req; // deklarirana globalna varijabla
function loadXMLDoc(naziv)
{
		if (window.XMLHttpRequest)
		{ // FF, Safari, Opera, IE7+
			req = new XMLHttpRequest(); // stvaranje novog objekta
		} else if (window.ActiveXObject)  // IE 6+
			req = new ActiveXObject("Microsoft.XMLHTTP"); //ActiveX
	if (req) 
	{ // uspješno stvoren objekt
		var url="http://localhost/or/detalji.php?naziv=" + naziv;
		var element = document.getElementById("detalji");
		element.innerHTML = '<img src="Spinning_wheel_throbber.gif" alt="Tražim..." />';
		req.open("GET", url, true); // metoda, URL, asinkroni način
		req.send(null); //slanje (null za GET, podaci za POST)
		req.onreadystatechange = function doSomething () 
			{
				if (req.readyState == 4) 
				{ // primitak odgovora
					if (req.status == 200)
					{
					// kôd statusa odgovora = 200 OK
					// kod uspješnog odgovora
					element.innerHTML = req.responseText;
					} else 
					{ 
					// kôd statusa nije OK
					element.innerHTML = ("Nije primljen 200 OK, nego:\n" + req.statusText);
					}			
				}
			};
	}
}
function generirajMapu(id,sirina, duzina, naziv,web)
{
	if (sirina !== '') 
	{
		document.getElementById('mapContainer').innerHTML = "<div id='map' style='height:290px;'></div>";
		var map=L.map('map').setView([sirina, duzina],13);
		L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(map);
		L.marker([sirina, duzina]).addTo(map)
		.bindPopup('<b>'+naziv+'</b><br/>Širina: '+sirina+'<br/>Dužina: '+duzina+'<br/>'+'<a href="'+web+'">Službena stranica</a>')
		.openPopup();
	}
	else
	{
	document.getElementById('mapContainer').innerHTML = "<div id='map'></div>";
	}
}