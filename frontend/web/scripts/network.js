var objMarkers = new Array(); 
                
        function initialize()
        {
            var sf =  new Array();
            var objPrevInfoWindow;
            var objCenterLatLong = new google.maps.LatLng(22.308068, 73.184060);
            var objMapProperties = { center: objCenterLatLong, zoom: 10, mapTypeId: google.maps.MapTypeId.ROADMAP, mapTypeControlOptions: { mapTypeIds: [] } };
            objMap = new google.maps.Map(document.getElementById("map"), objMapProperties);
			
			
           data = [
			  [22.317857, 73.178584,"techniansh Capital"],
			];


/*, options:[icon: "http://maps.google.com/mapfiles/marker_green.png"]*/
            console.log(data);
            
            vLength = data.length;
            
            for(i=0; i<vLength; i++)
            {
                var objPosition = new google.maps.LatLng(data[i][0], data[i][1]);
				var objMarker = new google.maps.Marker( { map: objMap, position: objPosition,icon:'http://192.168.1.250/techniansh-capital/html/images/marker.png'} );

//				var objMarker = new google.maps.Marker( { map: objMap, position: objPosition, title: data[i][2] } );
                objMarker.set('name', data[i][2]);
                
                objMarkers[data[i][2]] = objMarker;
                
                google.maps.event.addListener(objMarkers[data[i][2]], 'mouseover', function()
                {	
                    if(objPrevInfoWindow) objPrevInfoWindow.close();
                    var objInfoWindow = new InfoBox({content:'<div class="map_locations">' + this.get('name') + '</div>', disableAutoPan: false, maxWidth: 0, pixelOffset: new google.maps.Size(-30, 0), zIndex: null, closeBoxMargin: "0px 0px 0px 0px", closeBoxURL1: "./images/close.png", infoBoxClearance: new google.maps.Size(1, 1), isHidden: false, pane: "floatPane", enableEventPropagation: false  });
                    objInfoWindow.open(objMap, this);
                    objPrevInfoWindow = objInfoWindow;
                });
            }
        
        }
		
        google.maps.event.addDomListener(window, 'load', initialize);


