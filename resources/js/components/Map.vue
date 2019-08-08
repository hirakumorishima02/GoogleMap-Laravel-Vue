<template>
    <div>
        <router-link :to="{ name: 'detail', params: { id: 1 } }" class="mx-auto btn btn-success">More Info</router-link>
        <GmapAutocomplete
          @place_changed="setPlace">
        </GmapAutocomplete>
        <!--<input type='text' v-model='name' placeholder='地名'>-->
        
        <button @click="addMarker">Add</button>
      <br/>
        <GmapMap
          :center="{lat:10, lng:10}"
          :zoom="1"
          map-type-id="terrain"
          style="width:100%;  height: 400px;"
        >
            <GmapMarker
                :key="index"
                v-for="(marker, index) in destinations"
                :position="marker.position"
                :clickable="true"
                @click="toggleInfoWindow(marker, marker.id)"
            />
            <gmap-info-window
                :options="infoOptions"
                :position="infoWindowPos"
                :opened="infoWinOpen"
                @closeclick="infoWinOpen=false"
            >
                <div v-html="infoContent"></div>
            </gmap-info-window>
        </GmapMap>
    </div>
</template>

<script>
export default{
    data: function() {
        return {
            // getDestinations関係
            center: { lat: 45.508, lng: -73.587 },
            destinations:  [],
            places: [],
            currentPlace: null,
            
            // addMarker関係
            name: '',
            photo:'',
            
            // infoWindow
            infoContent: '',
            infoWindowPos: {
                lat: 0,
                lng: 0
            },
            infoWinOpen: false,
            currentMidx: null,
            //optional: offset infowindow so it visually sits nicely on top of our marker
            infoOptions: {
                pixelOffset: {
                    width: 0,
                    height: -35
                }
            }
        }
    },
    mounted: function() {
        this.getDestinations();
    },
    methods: {
        // destinationsテーブルの全取得
        getDestinations: function() {
            axios.get('/api/destinations')
            .then((res) => {
                this.destinations = res.data.data;
                this.destinations.map(marker => {
                    marker.position = { lat: parseFloat(marker.lat), lng: parseFloat(marker.lng) }
                })
            }).catch(err => {
                console.log('err reason:', err);
            });
            console.log('getDestinations')
        },
        // GmapAutocompleteで選択された場所をcurrentPlaceに格納
        setPlace: function(place) {
          this.currentPlace = place;
        },
        // マーカーをGmapとdestinationsテーブルへ追加
        addMarker: function() {
          if (this.currentPlace) {
            const marker = {
              lat: this.currentPlace.geometry.location.lat(),
              lng: this.currentPlace.geometry.location.lng(),
              name: this.currentPlace.formatted_address,
              photo: this.currentPlace.photos[0],
            };
            console.log(this.currentPlace)
            // Gmap関係
            this.destinations.push({ position: marker });
            this.places.push(this.currentPlace);
            this.center = marker;
            this.currentPlace = null;
            // destinationsテーブル関係
            axios.post('/api/destinations',{
                name: marker.name,
                lat: marker.lat,
                lng: marker.lng,
                photo: '',
            }).then((res)=>{
                this.name = '';
                this.lat = '';
                this.lng = '';
                this.photo = '';
                console.log('addMarker Success!');
            });
          }
        },
            toggleInfoWindow: function (marker, idx) {

                this.infoWindowPos = ({
                        lat : parseFloat(marker.lat),
                        lng : parseFloat(marker.lng),
                    }
                );
                this.infoContent = this.getInfoWindowContent(marker);

                //check if its the same marker that was selected if yes toggle
                if (this.currentMidx == idx) {
                    this.infoWinOpen = !this.infoWinOpen;
                }
                //if different marker set infowindow to open and reset current marker index
                else {
                    this.infoWinOpen = true;
                    this.currentMidx = idx;
                }
            },

            getInfoWindowContent: function (marker) {
                return(`<div class="info_window container">
                          <h3>${marker.name}</h3>
                          <router-link :to="{ name: 'detail', params: { id: ${marker.id} } }" class="mx-auto btn btn-success">More Info</router-link>
                         </div>`);
            },
    }
}
</script>