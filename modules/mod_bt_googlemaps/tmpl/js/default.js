function initializeMap(configs){
	var myLatlng;
	configs.width = configs.width =='auto' || configs.width =='100%' ? "100%":configs.width + 'px';
	configs.height = configs.height =='auto' || configs.height =='100%' ? "100%":configs.height + 'px';
	//configs.contentInfo = '<h3>'+configs.title+'</h3>'+configs.contentInfo;
	document.getElementById(configs.cavas_id).style.width=configs.width;
	document.getElementById(configs.cavas_id).style.height=configs.height;
	
	if(configs.inputType=='address'){
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode( { 'address': configs.address}, function(results, status) {
		  if (status == google.maps.GeocoderStatus.OK) {
			myLatlng = results[0].geometry.location;
			startMap(configs,myLatlng);
		  } else {
			alert("Geocode was not successful for the following reason: " + status);
		  }
		});
	}else{
		myLatlng = new google.maps.LatLng(configs.latitude,configs.longitude );
		startMap(configs,myLatlng);
	}
}
function startMap(configs,myLatlng){
	var myOptions = {
      zoom: configs.zoom,
      zoomControl: configs.zoomControl,
      scaleControl: configs.scaleControl,
      mapTypeControl: configs.mapTypeControl,
      panControl: configs.panControl,
      streetViewControl: configs.streetViewControl,
      overviewMapControl: configs.overviewMapControl,
      center: myLatlng,
      mapTypeId: configs.mapType
    }

    var map = new google.maps.Map(document.getElementById(configs.cavas_id), myOptions);
	var image = new google.maps.MarkerImage(
		  configs.image,
		  new google.maps.Size(21,32),
		  new google.maps.Point(0,0),
		  new google.maps.Point(11,32)
		);

	var shadow = new google.maps.MarkerImage(
	  configs.shadow,
	  new google.maps.Size(41,32),
	  new google.maps.Point(0,0),
	  new google.maps.Point(11,32)
	);
	
	if(configs.marker){
		var marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			shadow: shadow,
			icon: image,
			title: configs.title
		});
		
		if(configs.contentInfo){
			var infowindow = new google.maps.InfoWindow({
				content: configs.contentInfo
			});
			if(configs.showContentOnload){
				infowindow.open(map,marker);
			}
			google.maps.event.addListener(marker, 'click', function() {
			  infowindow.open(map,marker);
			});
			
		}
	}
}