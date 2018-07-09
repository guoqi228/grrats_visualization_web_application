<!DOCTYPE html>
<html>
<head>
    <title>OSU_GRRATS_ALPHA_2.0</title>
    <meta charset="utf-8" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/index_7.css">
    <?php
			include 'lat.php'; 
			include 'lon.php';
			include 'id.php';
			include 'dlink.php';
		?>
    <script type='text/javascript'>
    var map, searchManager;
    // load data in php file
    var lat = <?php echo json_encode($lat_array); ?>;
    var lon = <?php echo json_encode($lon_array); ?>;
    var iid = <?php echo json_encode($id_array); ?>;
    var dlink = <?php echo json_encode($dlink_array); ?>;
    //
		function loadMapScenario() {
				    // define map which will be shown in div id="my map"
		        map = new Microsoft.Maps.Map(document.getElementById('myMap'), {
		        credentials: 'your key here',
		        center: new Microsoft.Maps.Location(39.68, 176.50),
		        maxZoom: 15,
		        minZoom: 3,
		        mapTypeId: Microsoft.Maps.MapTypeId.aerial,
		        labelOverlay: Microsoft.Maps.LabelOverlay.hidden,
		        zoom: 3,
		        showDashboard: true});
		    var num = lat.length;
		    var pushpins = Microsoft.Maps.TestDataGenerator.getPushpins(num, map.getBounds());
		    var new_pushpins = Microsoft.Maps.TestDataGenerator.getPushpins(1, map.getBounds());
		    var pinlocation = Microsoft.Maps.TestDataGenerator.getLocations(num);
		    var new_pinlocation = Microsoft.Maps.TestDataGenerator.getLocations(1);
		    //var infoboxTemplate = '<div style="width:600px; height:300px; border: 10px solid Red;"> </div>';
		    //var infoboxTemplate = '<div id="infoboxText" style="background-color:White; border-style:solid; border-width:medium; border-color:Black; min-height:200px; width: 400px; "><b id="infoboxTitle" style="position: absolute; top: 10px; left: 10px; width: 220px; ">{title}</b><a id="infoboxDescription" style="position: absolute; top: 30px; left: 10px; width: 400px; ">{description}</a></div>';
		    var infobox = new Microsoft.Maps.Infobox(pushpins[0].getLocation(), {visible: false});
		    infobox.setMap(map);
		    for (var i = 0; i < pushpins.length; i++) {
		    				// add my own code here
		    				new_pinlocation = new Microsoft.Maps.Location(lat[i], lon[i]);
		     				new_pushpins = new Microsoft.Maps.Pushpin(new_pinlocation,{title: 'ID: ' +  iid[i]});
		    				pushpins[i] = new_pushpins;
		    				// end here
		     				//Store some metadata with the pushpin
		     				new_pushpins.metadata = {
		        		    title: iid[i],
		        		    description: 'ID: ' +  iid[i]};
		        		Microsoft.Maps.Events.addHandler(new_pushpins, 'click', function (args) {
		        		//function closeInfobox() {infobox.setOptions({ visible: false });};
		            infobox.setOptions({                   	
		                location: args.target.getLocation(),
		                title: args.target.metadata.title,
		                //showCloseButton: false,
		                description: args.target.metadata.description,                                                                                                                                                                             //<a id="ibox-close" class="infobox-close" onclick="closeInfoBox()">x</a>                                                                                                                                  fig_html/Amazon_Envisat_21.html?autosize=True frameborder="0" scrolling="no" 
		                //htmlContent: '<div class="parent"><p class="text">'+ args.target.metadata.title + '<a id="dataurl" href="ncdata/'+ args.target.metadata.title + '.nc" download="'+args.target.metadata.title +'.nc">Download Data</a><a id="ibox-close" class="infobox-close" href="javascript::closeInfoBox()" onclick="javascript::closeInfoBox()"><img id="closebutton" src="img/close.png"/><a></p><img class="center" src="fig/'+ args.target.metadata.title +'.png"/></div>',style="-webkit-transform:scale(0.5);-moz-transform-scale(1.0);"
		                htmlContent: '<div class="box"><p class="text" align="center">Click here to <a id="dataurl" href="ncdata/'+ args.target.metadata.title + '.nc" download="'+args.target.metadata.title +'.nc"> Download Data</a> and <a id="dataurl" target="_blank" href="fig_html/'+ args.target.metadata.title + '.html">Explore Figure</a> &copy;2017 The Ohio State University<span id="closebutton" onclick="this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode); return false;">x</span></p><p><div class="figbox"><img class="fig" src="fig/'+ args.target.metadata.title +'.png"/></div></p></div>',
		                //htmlContent: '<div id="container" style="background-color:White;border:5px solid Gray;border-radius:10px;height:300px;width:600px;"><p style="font-family:sans-serif;font-weight:bold;padding-left:80px;font-style: italic;">'+ args.target.metadata.title + '<a style="padding-left:80px;font-style: italic;" href="ncdata/'+ args.target.metadata.title + '.nc" download="'+args.target.metadata.title +'.nc">Download Data</a><img id="close-button" src="img/close.png" style="width:20px;height:20px;padding-bottom:5px;padding-left:35px;"> </p><img src="fig/'+ args.target.metadata.title +'.png" style="width:500px; height:250px;"/></div>',
		                visible: true });
		            	map.setView({ 
		            		center: args.target.getLocation(), 
		            		zoom: map.getZoom() });
		            		
		        });
		        //Microsoft.Maps.Events.addHandler(infobox, 'click', function () { 
		        //    		infobox.setOptions({ visible: false }); });
		        // 
		        };
		        Microsoft.Maps.Events.addHandler(map, 'click', function () {infobox.setOptions({ visible: false });});
		    		map.entities.push(pushpins);	
          };
    function Search() {
        if (!searchManager) {
            //Create an instance of the search manager and perform the search.
            Microsoft.Maps.loadModule('Microsoft.Maps.Search', function () {
                searchManager = new Microsoft.Maps.Search.SearchManager(map);
                Search()
            });
        } else {
            //Remove any previous results from the map.
            //map.entities.clear(pins);
            //Get the users query and geocode it.
            var query = document.getElementById('searchTbx').value;
            geocodeQuery(query);
        }
    }
    function geocodeQuery(query) {
        var searchRequest = {
            where: query,
            callback: function (r) {
                if (r && r.results && r.results.length > 0) {
                    var pin, pins = [], locs = []//, output = 'Results:<br/>';
                    for (var i = 0; i < r.results.length; i++) {
                        //Create a pushpin for each result. 
                        pin = new Microsoft.Maps.Pushpin(r.results[i].location, {
                         		color: 'yellow'
                        });
                        pins.push(pin);
                        locs.push(r.results[i].location);
                        //output += i + ') ' + r.results[i].name + '<br/>';
                    }
                    //Add the pins to the map
                    map.entities.push(pin);
                    //Display list of results
                    //document.getElementById('output').innerHTML = output;
                    //Determine a bounding box to best view the results.
                    //var bounds;
                    //if (r.results.length == 1) {
                    //    bounds = r.results[0].bestView;
                    //} else {
                    //    //Use the locations from the results to calculate a bounding box.
                    //    bounds = Microsoft.Maps.LocationRect.fromLocations(locs);
                    //}
                    map.setView({ center:pin.getLocation(),zoom:5 });
                }
            },
            errorCallback: function (e) {
                //If there is an error, alert the user about it.
                alert("No results found.");
            }
        };
        //Make the geocode request.
        searchManager.geocode(searchRequest);
    }
    </script>
    <script type='text/javascript' src='/BingMapsCredentials.js'></script>
    <script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=loadMapScenario' async defer> </script>
</head>
<body>
		<div class='bar'>
    <input id='searchTbx' type='text' value='Latitude,Longitude'/>
    <input type='button'value='Search' onclick='Search()'/> </div>

    <div id='myMap' style='width: 100vw; height: 100vh; position:relative;'></div>
</body>
</html>