<?php
echo $_SERVER['SERVER_NAME']."<br>\n";
 $lat='48.697391';
 $lon='20.096548';
 $zoom='5';
?>
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
 <link rel="stylesheet" href="AddressSearch.css" />
 <link rel="stylesheet" href="leaflet-routing-machine.css" />

</head>
<body bgcolor="black" align="center">

<font color="white">
 <script>
  document.write(window.innerWidth-"50"+"px x ");
  document.write(window.innerHeight-"70"+"px");
 </script>
</font>

<table id="map" width="100" align="center">
 <td id="maph" height="100" align="center">
 </td>
</table>


<script>
 document.getElementById("map").width = window.innerWidth-"50";
 document.getElementById("maph").height = window.innerHeight-"70";
</script>


<script src="leaflet.js"></script>
<script src="AddressSearch.js"></script>


<script>
var map = L.map('map').setView([<?php echo $lat;?>, <?php echo $lon;?>], <?php echo $zoom;?>);
var marker = null;
var myAPIKey = "054b7c9fcae24adf9976f2e5b6982fa0";


<?php
if ($_SERVER['SERVER_NAME'] == "mapy.ztk-comp.sk") { ?>
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18}).addTo(map);
//L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', { maxZoom: 17}).addTo(map);
<?php
} else {
?>
L.tileLayer('{z}/{x}/{y}.png', { maxZoom: 18}).addTo(map);
<?php
}
?>

///// Search box
const addressSearchControl = L.control.addressSearch(myAPIKey, {
 position: 'topleft',
 resultCallback: (address) => {
  if (marker) {
   marker.remove();
  }

  if (!address) {
   return;
  }

///// Show marker from search
  marker = new L.circle([address.lat, address.lon], 5, {
    color: '#000000',
    fillColor: '#FF0000',
    fillOpacity: 3,
    radius: 1
    }).addTo(map);

  if (address.bbox && address.bbox.lat1 !== address.bbox.lat2 && address.bbox.lon1 !== address.bbox.lon2) {
   map.fitBounds([[address.bbox.lat1, address.bbox.lon1], [address.bbox.lat2, address.bbox.lon2]], { padding: [100, 100] })
  } else {
   map.setView([address.lat, address.lon], 15);
  }
 },
 suggestionsCallback: (suggestions) => {
  console.log(suggestions);
 }
});

map.addControl(addressSearchControl);


///// Get GPS from click
var popup = L.popup();
function onMapClick(e) {
 popup
 .setLatLng(e.latlng)
 .setContent("<b>Your position on map</b> <br>" + "<b>Lat:</b> " + e.latlng.lat.toFixed(6) + "<br> <b>Lon:</b> " + e.latlng.lng.toFixed(6))
 .openOn(map);
}
map.on('click', onMapClick);


<?php
///// Show marker(s)
if ((!empty($_GET["lat"])) && (!empty($_GET["lon"]))) {
echo $marker;
?>

for (var i = 0; i < latLong.length; i++) {
    marker = new L.circle([latLong[i][1],latLong[i][2]], 5, {
    color: '#000000',
    fillColor: '#FF0000',
    fillOpacity: 3,
    radius: 1
    }).addTo(map).bindPopup(latLong[i][0]);
}
<?php
 }
?>

</script>

</body>
</html>
