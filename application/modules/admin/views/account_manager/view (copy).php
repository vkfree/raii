<div class="site-content">
	
	<div class="content-area py-1">
		<div class="container-fluid">
			<div class="box box-block bg-white">
				<h4>Request details</h4>
				<div class="row" style="color: black">
					<div class="col-md-6">
						<dl class="row">
							<dt class="col-sm-4">User Name :</dt>
							<dd class="col-sm-8">Zooey</dd>
							<dt class="col-sm-4">Provider Name :</dt>
							<dd class="col-sm-8">Carlos</dd>
							
							<dt class="col-sm-4">Total Distance :</dt>
							<dd class="col-sm-8">-</dd>
							<dt class="col-sm-4">Ride Start Time :</dt>
							<dd class="col-sm-8">
							4th of July 2018 07:33:45 AM
							</dd>
							<dt class="col-sm-4">Ride End Time :</dt>
							<dd class="col-sm-8">
							
							4th of July 2018 07:34:18 AM
							</dd>
							
							<dt class="col-sm-4">Pickup Address :</dt>
							<dd class="col-sm-8">9347 Bales Ave, Kansas City, MO 64132, USA</dd>
							<dt class="col-sm-4">Drop Address :</dt>
							<dd class="col-sm-8">12345 College Blvd, Overland Park, KS 66210, USA</dd>
							<dt class="col-sm-4">Base Price :</dt>
							<dd class="col-sm-8">$7.12</dd>
							<dt class="col-sm-4">Distance Price :</dt>
							<dd class="col-sm-8">$-1</dd>
							<dt class="col-sm-4">Service Charges :</dt>
							<dd class="col-sm-8">$0.66</dd>
							<dt class="col-sm-4">Discount Price :</dt>
							<dd class="col-sm-8">$0.00</dd>
							<dt class="col-sm-4">Tax Price :</dt>
							<dd class="col-sm-8">$0.00</dd>
							<dt class="col-sm-4">Surge Price :</dt>
							<dd class="col-sm-8">$0.12</dd>
							<dt class="col-sm-4">Total Amount :</dt>
							<dd class="col-sm-8">$6.12</dd>
							<dt class="col-sm-4">Wallet Deduction :</dt>
							<dd class="col-sm-8">$0.00</dd>
							<dt class="col-sm-4">Paid Amount :</dt>
							<dd class="col-sm-8">$6.12</dd>
							<dt class="col-sm-4">Provider Earnings:</dt>
							<dd class="col-sm-8">$5.28</dd>
							<dt class="col-sm-4">Provider Admin Commission :</dt>
							<dd class="col-sm-8">$0.72</dd>
							
							<dt class="col-sm-4">Ride Status : </dt>
							<dd class="col-sm-8">
							COMPLETED
							</dd>
						</dl>
					</div>
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

    