
/* MAPA DE DESTAQUE */
var latitudeDestaque = $("#latitudeDestImovel").val();
var longitudeDestaque = $("#longitudeDestImovel").val();
var enderecoCompleto = $("#enderecoCompletoEmpresaAqui").val();

var map;
var infowindow;
var myLatlng;
var marker = [];
var service;
var aPlaces = [];
var markeres = [];
var radio = '';

function initialize() {
  /* Colocar a latitude e longitude do mapa */
  myLatlng = new google.maps.LatLng(latitudeDestaque, longitudeDestaque);
  /* parametros do mapa */
  var mapOptions = {
    zoom: 14,
    center: myLatlng
  };
  /* insere o mapa */
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  /* icone do mapa */
  var image = pathSite+'media/imagens/mapa.png';
  /* adciona o icone no mapa */
  markerfull = new google.maps.Marker({
      position: myLatlng,
      map: map,
      icon: image,
      animation: google.maps.Animation.DROP
  });
  /* informação no balão do mapa */
  var contentString = enderecoCompleto;
  /* adciona o evento no icone para quando clicar aparecer o balao */
  google.maps.event.addListener(markerfull, 'click', function() {
	  //infowindow.open(map,markerfull);
	  $('<div>'+contentString+'</div>').dialog({ title:'Endereço do imóvel', resizable:false, draggable:false, buttons: [ { text: "Ok", click: function() { $( this ).dialog( "close" ); } } ] });
  });

  
}

function createMarker(place) {
 var image = {
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(25, 25)
  };
  marker = new google.maps.Marker({
    position: place.geometry.location,
    icon: image,
    map: map
  });
  
  markeres.push(marker);
  

  google.maps.event.addListener(marker, 'click', function() {
    $('<div><img style="float:left; width:50px; padding-right:5px;" src="'+place.icon+'"/>'+place.name+'<br/>'+place.vicinity+'</div>').dialog({ title:'Estabelecimento', resizable:false, draggable:false, buttons: [ { text: "Ok", click: function() { $( this ).dialog( "close" ); } } ] });
  });
}

function addRadius(){
	  
	radio = new google.maps.Circle({
		  center:myLatlng,
		  radius:1600,
		  strokeColor:"red",
		  strokeOpacity:0.1,
		  strokeWeight:1,
		  fillColor:"red",
		  fillOpacity:0.1
		  });

	radio.setMap(map);
}

function clearOverlays() {
	for (var i = 0; i < markeres.length; i++) {
		markeres[i].setMap(null);
	  }
}

function addPlaces(types,radius){
	var request = {
	    location: myLatlng,
	    radius: 1500,
	    types: types
	  };
	  infowindow = new google.maps.InfoWindow();
	  service = new google.maps.places.PlacesService(map);
	  service.nearbySearch(request, callback);
	  
	  
}

function callback(results, status) {
if (status == google.maps.places.PlacesServiceStatus.OK) {
  for (var i = 0; i < results.length; i++) {
    createMarker(results[i]);
  }
}
}

$(function(){
	$('.map__control input').click(function(){
		aPlaces = [];
		$('.map__control input:checked').each(function(i){
			aPlaces[i] = $(this).val();
		});
		clearOverlays();
		if(aPlaces != ''){
			addPlaces(aPlaces,1500);
			if(radio == ''){
				addRadius();
			}
		}else{
			radio.setMap(null);
			radio = '';
		}
		
	});

});
if(latitudeDestaque && longitudeDestaque && latitudeDestaque != '0.0000' && longitudeDestaque != '0.0000'){
	google.maps.event.addDomListener(window, 'load', initialize);
}