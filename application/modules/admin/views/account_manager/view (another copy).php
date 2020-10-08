<div class="site-content">
	
	<div class="content-area py-1">
		<div class="container-fluid">
			<div class="box box-block bg-white">
				<h4>Request details</h4>
				<div class="row" style="color: black">
					<div class="col-md-6">
						<div id="map" style="width:100%;height:400px;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

    <!-- Vendor JS -->
    
    <script type="text/javascript">
    var map;
    var zoomLevel = 15;

    function initMap() {

        map = new google.maps.Map(document.getElementById('map'));

        var marker = new google.maps.Marker({
            map: map,
            // icon: 'https://cdn.pixabay.com/photo/2014/04/03/10/31/marker-310760_960_720.png',
            anchorPoint: new google.maps.Point(0, -29)
        });

         var markerSecond = new google.maps.Marker({
            map: map,
            // icon: 'https://cdn.pixabay.com/photo/2014/04/03/10/31/marker-310760_960_720.png',
            anchorPoint: new google.maps.Point(0, -29)
        });

        var bounds = new google.maps.LatLngBounds();

        source = new google.maps.LatLng(18.577330699999997, 73.76988370000004);
        destination = new google.maps.LatLng(18.5073985, 73.80765040000006);

        marker.setPosition(source);
        markerSecond.setPosition(destination);

        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true});
        directionsDisplay.setMap(map);

        directionsService.route({
            origin: source,
            destination: destination,
            travelMode: google.maps.TravelMode.DRIVING
        }, function(result, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                console.log(result);
                directionsDisplay.setDirections(result);

                marker.setPosition(result.routes[0].legs[0].start_location);
                markerSecond.setPosition(result.routes[0].legs[0].end_location);
            }
        });
        
        bounds.extend(marker.getPosition());
        bounds.extend(markerSecond.getPosition());
        map.fitBounds(bounds);
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC703aCvZmrdfFlNxArFXzBL_OBNuF4AC4&amp;libraries=places&amp;callback=initMap" async="" defer=""></script>

    