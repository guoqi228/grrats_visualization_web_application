
function createmap() {
		var map_center = new Microsoft.Maps.Location(50,50);
    map = new Microsoft.Maps.Map(document.getElementById('myMap'), {
        'credentials': 'FrZj2gmRNfLZSmVG1cKg~p3R8T5bwoe3Q8MfgAcyjxg~AohTm4ybRMbUyEi8A4AsW5aNfOz0tBT1emyX58SJHg5DqYyJBlH5QCBlemYmqsTp',
        'center': map_center,
        'mapTypeID': Microsoft.Map.MapTypedID.road,
        'zoom':10
    });
    
}

        
        
$(document).ready(function(){
	createmap();
	});
	
	