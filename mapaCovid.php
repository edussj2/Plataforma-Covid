<html>
  <head>
    <title>Mapa Covid</title>
    <link rel="icon" type="image/png" href="./vistas/assets/iconos/iconoVirus.png"/>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <style>
        /* [START maps_map_simple] */
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

        /* [END maps_map_simple] */
    </style>

  </head>
  <body>
    <div id="map"></div>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCnVRQmeLeyyf82IOzs-iOUD6GVNzH2hNU&callback=initMap&libraries=&v=weekly"
      async
    ></script>
    <script>
        // [START maps_map_simple]
        let map;

        function initMap() {
          map = new google.maps.Map(document.getElementById("map"), {
              center: { lat: 0, lng: 0 },
              zoom: 3
          });
        }
        // [END maps_map_simple]
        
        renderData();

        async function getData() {
          const response = await fetch('https://master-covid-19-api-laeyoung.endpoint.ainize.ai/jhu-edu/latest')
          const data = await response.json()
          return data
        }

        async function renderData(){
          const data = await getData();
          console.log(data);
        }
    </script>
  </body>
</html>