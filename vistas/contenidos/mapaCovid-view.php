<section class="tarjetas-global">
    <div class="container">
        <h2 class="mt-3 mb-3 pb-1 text-center"><i class="fas fa-globe-americas"></i> Mapa del Covid</h2>
        <div class="row">
            <div class="map" id="map" style="height: 100%;"></div> 
        </div>
    </div>
</section>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCnVRQmeLeyyf82IOzs-iOUD6GVNzH2hNU&callback=initMap&libraries=&v=weekly" async ></script>
<script>
        // [START maps_map_simple]
        let map;

        function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: -34.397, lng: 150.644 },
            zoom: 8,
        });
        }
        // [END maps_map_simple]
</script>