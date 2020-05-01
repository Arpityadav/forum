<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :reply="reply" @deleted="remove(index)"></reply>
        </div>

        <paginator :dataSet="dataSet" @changed="fetch"></paginator>

        <p v-if="$parent.locked">This thread has been locked. You cannot leave a reply at the moment.</p>
        <new-reply v-else @created="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from './NewReply.vue';
    import collection from '../mixins/Collection';


    export default {
        name: 'Replies',

        components: { Reply, NewReply },

        mixins: [collection],

        data() {
            return {
                dataSet: false,
            }
        },

        created() {
            this.fetch();
        },

        methods: {
            url(page) {
                if (! page) {
                    let query = location.search.match(/page=(\d+)/);

                    page = query ? query[1] : 1;
                }

                return `${location.pathname}/replies?page=${page}`;
            },

            fetch(page) {
                axios.get(this.url(page))
                    .then(this.refresh);
            },

            refresh({data}) {
                this.dataSet = data;
                this.items = data.data;

                window.scroll(0, 0);
            }

        }
    }
</script>
