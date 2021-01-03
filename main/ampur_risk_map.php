<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');
$sql="SELECT
    amp_id,amp_code,amp_name_t,points10 as points,r.background_color
    FROM
    Amphoe_PROV m left join ampur a on m.amp_code=a.ampur_code_full left join risk_level r on a.risk_status_id=r.risk_level_id 
    ";
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Polygon Arrays</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBOuXmW899WB6Wulz_Enpz6trqYblNRJQ&callback=initMap&libraries=&v=weekly"
      defer
    ></script>
    <style type="text/css">
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }

      /* Optional: Makes the sample page fill the window. */
      html,
      body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
    <script>
      // This example creates a simple polygon representing the Bermuda Triangle.
      // When the user clicks on the polygon an info window opens, showing
      // information about the polygon's coordinates.
      let map;
      let infoWindow;
      let bermudaTriangle;
      let ampurs=JSON.parse('<?php echo json_encode($rows); ?>');
      function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
          zoom: 5,
          center: { lat: 17.683463424,lng: 103.419288504 },
          mapTypeId: "terrain",
        });
        // Define the LatLng coordinates for the polygon.
        for (let index = 0; index < ampurs.length; index++) {
            const points = ampurs[index]['points'];
            let background_color=ampurs[index]['background_color'];
            let a_points = points.split("|");
            let triangleCoords=[];
            for (let point_i = 0; point_i < a_points.length; point_i++) {
                let xy = a_points[point_i].split(",");
                let x = parseFloat(xy[0]);
                let y = parseFloat(xy[1]);
                let latlng = {lat:y,lng:x};
                if (y<=0){
                    console.log(y);
                }
                triangleCoords.push(latlng);
            }
            // console.log(index);
            // console.log(triangleCoords);
            bermudaTriangle = new google.maps.Polygon({
                paths: triangleCoords,
                strokeColor: "#FFFFFF",
                strokeOpacity: 0.3,
                strokeWeight: 1,
                fillColor: background_color,
                fillOpacity: 0.8,
            });
            bermudaTriangle.setMap(map);
            // Add a listener for the click event.
            bermudaTriangle.addListener("click", showArrays);
            infoWindow = new google.maps.InfoWindow();

        }
      }

      function showArrays(event) {
        // Since this polygon has only one path, we can call getPath() to return the
        // MVCArray of LatLngs.
        const polygon = this;
        const vertices = polygon.getPath();
        let contentString =
          "<b>Bermuda Triangle polygon</b><br>" +
          "Clicked location: <br>" +
          event.latLng.lat() +
          "," +
          event.latLng.lng() +
          "<br>";

        // Iterate over the vertices.
        for (let i = 0; i < vertices.getLength(); i++) {
          const xy = vertices.getAt(i);
          contentString +=
            "<br>" + "Coordinate " + i + ":<br>" + xy.lat() + "," + xy.lng();
        }
        // Replace the info window's content and position.
        infoWindow.setContent(contentString);
        infoWindow.setPosition(event.latLng);
        infoWindow.open(map);
      }
    </script>
  </head>
  <body>
    <div id="map"></div>
  </body>
</html>