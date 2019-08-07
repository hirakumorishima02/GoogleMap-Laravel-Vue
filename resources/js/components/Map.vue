<template>
    <div id="map" :style='{width: mapWidth + "px" , height: mapHeight + "px"}' />
</template>

<script>
let GoogleMapsLoader = require('google-maps');

GoogleMapsLoader.KEY = 'AIzaSyCYDBKZ0Hp66gi6wllOzGoE8oVuMUaxUD0';
GoogleMapsLoader.LANGAGE = 'ja';

export default{
    name: 'Gmap',
    props: {
        propsWidth: {
          type: Number
        },
        propsHeight: {
          type: Number
        },
        lat: {
          type: Number,
          default: 34.722677
        },
        lng: {
          type: Number,
          default: 135.492364
        },
        zoom: {
          type: Number,
          default: 8
        },
        markers: {
          type: Array,
          default: () => {
            return [];
          }
        }
    },
    data: function() {
        return {
            destinations: null,
            map: null,
            mapWidth: this.propsWidth,
            mapHeight: this.propsHeight,
            formattedMarkers: []
        }
    },
    created: function() {
        this.mapWidth = window.innerWidth;
        this.mapHeight = window.innerHeight;
    },
    watch: {
        markers() {
          // マーカーを全削除
          this.formattedMarkers.forEach(marker => {
            marker.setMap(null);
          });
          // propsからも削除
          this.formattedMarkers.splice(0, this.formattedMarkers.length);
    
          // 再描画
          this.addMarker();
        }
    },
    mounted: function() {
        this.getDestinations();
        GoogleMapsLoader.load(this.loadMap);
    },
    methods: {
        getDestinations: function() {
            axios.get('/api/destinations')
            .then((res) => {
                this.destinations = res.data.data;
            });
        },
        addMarker() {
            this.markers.forEach(markerInfo => {
                var contentString =
                  '<div id="content">' +
                  '<div id="siteNotice">' +
                  "</div>" +
                  '<h1 id="firstHeading" class="firstHeading">Uluru</h1>' +
                  '<div id="bodyContent">' +
                  "<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large " +
                  "sandstone rock formation in the southern part of the " +
                  "Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) " +
                  "south west of the nearest large town, Alice Springs; 450&#160;km " +
                  "(280&#160;mi) by road. Kata Tjuta and Uluru are the two major " +
                  "features of the Uluru - Kata Tjuta National Park. Uluru is " +
                  "sacred to the Pitjantjatjara and Yankunytjatjara, the " +
                  "Aboriginal people of the area. It has many springs, waterholes, " +
                  "rock caves and ancient paintings. Uluru is listed as a World " +
                  "Heritage Site.</p>" +
                  '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">' +
                  "https://en.wikipedia.org/w/index.php?title=Uluru</a> " +
                  "(last visited June 22, 2009).</p>" +
                  "</div>" +
                  "</div>";
                  
                  let marker = new google.maps.Marker({
                      position: markerInfo.position,
                      icon:
                        "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png",
                      map: this.map,
                      // ポップなアニメーションを付与
                      animation: google.maps.Animation.DROP
                  });
            });
        },
        loadMap(google) {
            this.map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: this.lat, lng: this.lng  },
                zoom: this.zoom,
            });
            this.addMarker();
        },
        release() {
          GoogleMapsLoader.release(function() {
            console.log("No google maps api around");
          });
        }
    }
}
</script>

<style>
#map {
    width: 700px;
    height: 400px;
}
</style>