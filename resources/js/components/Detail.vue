<template>
    <div>
        <div class="card-body">
            <h1 class="card-title">{{destination.name}}</h1>
            <div class="card-text">{{destination.memo}}</div>
        </div>
    </div>
</template>

<script>
export default {
    data: function( ) {
        return {
            destination: null
        }
    },
    mounted: function() {
        this.getDestination();
    },
    methods: {
        getDestination: function() {
            axios.get('/api/destinations/' + this.$route.params.id)
            .then( ( res ) => {
                this.destination = res.data.data;
            });
        }
    }
}
</script>