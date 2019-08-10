<template>
    <div>
        <div class="card-body">
            <h1 class="card-title">{{destination.name}}</h1>
            <div class="card-text" v-for='item in destination.memos'>{{item.content}}</div>
        </div>
        <input type='text' v-model='content'>
        <button type='submit' @click.prevent='addMemo'>post</button>
    </div>
</template>

<script>
export default {
    data: function( ) {
        return {
            destination: null,
            content: '',
        }
    },
    // memoのcontentが変化した時の処理
    watch: {
        content: function() {
        this.getDestination();
        }
    },
    mounted: function() {
        this.getDestination();
    },
    methods: {
        getDestination: function() {
            axios.get('/api/destinations/' + this.$route.params.id)
            .then((res) => {
                this.destination = res.data.data;
            });
        },
        addMemo: function() {
            axios.post('/api/memos',{
                id: this.$route.params.id,
                content: this.content,
            })
            .then((res) => {
                this.content = '';
            })
        }
    }
}
</script>