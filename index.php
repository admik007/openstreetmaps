<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
 <title> OpenStreetMaps - Leaflet </title>
 <meta http-equiv="Expires" CONTENT="Sun, 12 May 2003 00:36:05 GMT">
 <meta http-equiv="Pragma" CONTENT="no-cache">
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <meta http-equiv="Cache-control" content="no-cache">
 <meta http-equiv="Content-Language" content="sk">
 <meta name="google-site-verification" content="GHY_X_yeijpdBowWr_AKSMWAT8WQ-ILU-Z441AsYG9A">
 <meta name="GOOGLEBOT" CONTENT="noodp">
 <meta name="pagerank" content="10">
 <meta name="msnbot" content="robots-terms">
 <meta name="msvalidate.01" content="B786069E75B8F08919826E2B980B971A">
 <meta name="revisit-after" content="2 days">
 <meta name="robots" CONTENT="index, follow">
 <meta name="alexa" content="100">
 <meta name="distribution" content="Global">
 <meta name="keywords" lang="en" content="osm, openstreetmaps, maps, leaflet">
 <meta name="description" content="OpenStreetMaps with Leaflet in Docker">
 <meta name="Author" content="ZTK-Comp WEBHOSTING">
 <meta name="copyright" content="(c) 2019 ZTK-Comp">
 <meta charset="utf-8" />
 <link rel="stylesheet" href="leaflet.css" />
</head>
<body bgcolor="black" align="center">

<table id="map" width="100" align="center">
 <td id="maph" height="100" align="center">
 </td>
</table>

<script>
 document.getElementById("map").width = window.innerWidth-"50";
 document.getElementById("maph").height = window.innerHeight-"70";
</script>

<script src="leaflet.js"></script>

<script>
var map = L.map('map').setView([48.697391, 20.096548], 7);
L.tileLayer('{z}/{x}/{y}.png', { maxZoom: 18}).addTo(map);
//L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18}).addTo(map);

///// Get GPS from click
var popup = L.popup();
function onMapClick(e) {
 popup
 .setLatLng(e.latlng)
 .setContent("<b>Your position on map</b> <br>" + "<b>Lat:</b> " + e.latlng.lat.toFixed(6) + "<br> <b>Lon:</b> " + e.latlng.lng.toFixed(6))
 .openOn(map);
}
map.on('click', onMapClick);
</script>

</body>
</html>
