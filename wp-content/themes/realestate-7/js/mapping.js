/**
 * Contempo Mapping
 *
 * @package WP Pro Real Estate 5
 * @subpackage JavaScript
 */

var estateMapping = (function () {
	var self = {},
	    marker_list = [],
	    open_info_window = null,
	    x_center_offset = 0, // x,y offset in px when map gets built with marker bounds
	    y_center_offset = 0,
	    x_info_offset = -0, // x,y offset in px when map pans to marker -- to accomodate infoBubble
	    y_info_offset = -180;
	
	function build_marker(latlng, property) {
		
		var mapPin = '';
	    if(property['commercial'] == 'commercial') {
			var mapPin= property.siteURL+'/images/map-pin-com.png';
		} else if(property['land'] == 'land') {
			var mapPin= property.siteURL+'/images/map-pin-land.png';
		} else {
			var mapPin= property.siteURL+'/images/map-pin-res.png';
		}

	    var marker = new google.maps.Marker({
			map: self.map, 
			animation: google.maps.Animation.DROP,
			draggable: false,
			flat: true,
			icon: mapPin,   
			position: latlng
		});

		marker_list.push(marker);
	
	    self.bounds.extend(latlng);
		self.map.fitBounds(self.bounds);
        self.map.setCenter(convert_offset(self.bounds.getCenter(), x_center_offset, y_center_offset));

        var residentialString = '';
		if(property['commercial'] != 'commercial') {
			var residentialString=''+property.bed+' | '+property.bath+' | ';
		}

        var contentString =
		'<div class="infobox">'+
		'<div class="info-image"'+
			'<figure>'+
				'<a href="'+property.permalink+'">'+
					property.thumb+
				'</a>'+
			'</figure>'+
		'</div>'+
		'<div class="listing-details">'+
			'<header>'+
				'<h4 class="marB0"><a href="'+property.permalink+'">'+property.street+'</a></h4>'+
				'<p class="location marB0">'+property.city+', '+property.state+'&nbsp;'+property.zip+'</p>'+
			'</header>'+
			'<p class="price marB0"><strong>'+property.fullPrice+'</strong></p>'+
		'</div>';

		var infobox = new InfoBox({
			content: contentString,
			disableAutoPan: true,
			maxWidth: 0,
			alignBottom: true,
			pixelOffset: new google.maps.Size( -125, -64 ),
			zIndex: null,
			closeBoxMargin: "8px 0 -20px -20px",
			closeBoxURL: "wp-content/themes/realestate-7/images/infobox-close.png",
			infoBoxClearance: new google.maps.Size(1, 1),
			isHidden: false,
			pane: "floatPane",
            enableEventPropagation: false
		});

		google.maps.event.addListener(marker, 'click', function() {

			if(open_info_window) open_info_window.close();
		    
			
	            infobox.open(self.map, marker);
	            self.map.panTo(convert_offset(this.position, x_info_offset, y_info_offset));
	            open_info_window = infobox;
	         
		});
	}
	
    function geocode_and_place_marker(property) {
       var geocoder = new google.maps.Geocoder();
       var address = property.street+', '+property.city+' '+property.state+', '+property.zip;
           
           //If latlong exists build the marker, otherwise geocode then build the marker
           if (property['latlong']) {
               var lat = parseFloat(property['latlong'].split(',')[0]),
                    lng = parseFloat(property['latlong'].split(',')[1]);
                var latlng = new google.maps.LatLng(lat,lng);
                build_marker(latlng, property);
               
           } else {
               geocoder.geocode({ address : address }, function( results, status ) {
                   if(status == google.maps.GeocoderStatus.OK) {
        				var latlng = results[0].geometry.location;
        				build_marker(latlng, property);
        			}
        		});
            }
    }
    
    function init_canvas_projection() {
        function CanvasProjectionOverlay() {}
        CanvasProjectionOverlay.prototype = new google.maps.OverlayView();
        CanvasProjectionOverlay.prototype.constructor = CanvasProjectionOverlay;
        CanvasProjectionOverlay.prototype.onAdd = function(){};
        CanvasProjectionOverlay.prototype.draw = function(){};
        CanvasProjectionOverlay.prototype.onRemove = function(){};
        
        self.canvasProjectionOverlay = new CanvasProjectionOverlay();
        self.canvasProjectionOverlay.setMap(self.map);
    }
    
    function convert_offset(latlng, x_offset, y_offset) {
        var proj = self.canvasProjectionOverlay.getProjection();
        var point = proj.fromLatLngToContainerPixel(latlng);
        point.x = point.x + x_offset;
        point.y = point.y + y_offset;
        return proj.fromContainerPixelToLatLng(point);
    }
	
	self.init_property_map = function (properties, defaultmapcenter) {
    	var options = {
    		zoom: 10,
    		center: new google.maps.LatLng(defaultmapcenter.mapcenter),
    		mapTypeId: google.maps.MapTypeId.ROADMAP, 
    		disableDefaultUI: false,
    		scrollwheel: false,
    		streetViewControl: true,
    		styles: [{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]},{"featureType":"landscape","stylers":[{"color":"#f2e5d4"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"administrative","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"road"},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{},{"featureType":"road","stylers":[{"lightness":20}]}]
    	};

    	/* Marker Clusters */
        var markerClustererOptions = {
            ignoreHidden: true,
            maxZoom: 14,
            styles: [{
                textColor: '#ffffff',
                url: property.siteURL+'/images/cluster-icon.png',
                height: 48,
                width: 48
            }]
        };
        
    	self.map = new google.maps.Map( document.getElementById( 'map' ), options );
        self.bounds = new google.maps.LatLngBounds();
        init_canvas_projection();

        //wait for idle to give time to grab the projection (for calculating offset)
        var idle_listener = google.maps.event.addListener(self.map, 'idle', function() {
            for (i=0;i<properties.length;i++) {
                geocode_and_place_marker(properties[i]);
            }
            var markerCluster = new MarkerClusterer(self.map, marker_list, markerClustererOptions);
            google.maps.event.removeListener(idle_listener);
        });

        google.maps.event.addListenerOnce(map, 'tilesloaded', function() {
            google.maps.event.addListenerOnce(map, 'tilesloaded', function() {
                google.maps.event.trigger(map, 'resize');
            });
		});
	
	}
	
	return self;
}());