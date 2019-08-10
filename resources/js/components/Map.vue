<template>
    <div style='background-color:#FFF0F5;padding:0;'>
        <GmapAutocomplete
          @place_changed="setPlace"
          size='50'
          >
        </GmapAutocomplete>
        <!--<input type='text' v-model='name' placeholder='地名'>-->
        <button @click="addMarker">Add</button>
      <br/>
        <GmapMap
          :center="{lat:35, lng:160}"
          :zoom="1.7"
          map-type-id="roadmap"
          style="width:100%;  height: 800px;"
        >
            <GmapMarker
                :key="index"
                v-for="(marker, key , index) in destinations"
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
            <div class="info_window container" v-if="currentMarker">
              <h3>{{currentMarker.name}}</h3>
              <a href="#" class="mx-auto btn btn-success" @click.stop.prevent="routeToDetail">More Info</a>
              <a href="#" class="mx-auto btn btn-danger" @click.prevent="onDelete(currentMarker.id)">Delete</a>
            </div>
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
            },
            currentMarker: null
        }
    },
    mounted: function() {
        this.getDestinations();
    },
    // currentMarkerのcontentが変化した時の処理
    watch: {
        currentMarker: function() {
        this.getDestinations();
        }
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
        onDelete: function(id){
            axios.delete('/api/destinations/' + id)
            .then(() => {
                this.$delete(this.currentMarker);
                this.$delete(this.marker);
            })
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
              name: this.currentPlace.name,
              photo: this.currentPlace.photos[0],
            };
            this.currentMarker = marker;
            console.log(this.marker)
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
    toggleInfoWindow: function(marker, idx) {
      this.infoWindowPos = {
        lat: parseFloat(marker.lat),
        lng: parseFloat(marker.lng)
      };
       // これを追加
      this.currentMarker = marker;
      // this.infoContent = this.getInfoWindowContent(marker);
       //check if its the same marker that was selected if yes toggle
      if (this.currentMidx == idx) {
        this.infoWinOpen = !this.infoWinOpen;
      } else {
        //if different marker set infowindow to open and reset current marker index
        this.infoWinOpen = true;
        this.currentMidx = idx;
      }
    },
        routeToDetail: function() {
          this.$router.push({
            name: 'detail',
            params: {
              id: this.currentMarker.id
            }
          });
        }
    }
}
</script>