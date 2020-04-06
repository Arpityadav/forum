<template>
    <ul class="pagination" v-show="shouldPaginate">
    <li class="page-item" v-if="prevUrl">
        <a class="page-link" href="#" aria-label="Previous" @click.prevent="page--">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
        </a>
    </li>
    <!--    <li class="page-item"><a class="page-link" href="#">3</a></li>-->
    <li class="page-item" v-if="nextUrl">
        <a class="page-link" href="#" aria-label="Next" @click.prevent="page++">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
        </a>
    </li>
    </ul>
</template>

<script>

    export default {
        props: ['dataSet'],

        data() {
            return {
                prevUrl: false,
                nextUrl: false,
                page: 1,
            }
        },

        watch: {
            dataSet() {
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
                this.page = this.dataSet.current_page;
            },

            page() {
                this.broadcast().updateUrl();
            },
        },


        computed: {
            shouldPaginate() {
                return !! this.prevUrl || !! this.nextUrl;
            }
        },

        methods: {
            broadcast() {
                return this.$emit('changed', this.page);
            },

            updateUrl() {
                history.pushState(null, null, '?page=' + this.page);
            }
        }
    }

</script>
