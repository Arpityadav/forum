<template>
    <div :id="'reply-'+id" class="card my-3 ">
        <div class="card-header" :class="isBest ? 'text-success' : ''">
            <a :href="'/profiles/+data.owner.name'" class="flex" v-text="data.owner.name">
            </a> said <span v-text="ago"></span>

            <favorite :reply="data" v-if="signedIn"></favorite>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <form @submit="update">
                    <textarea class="form-control" v-model="body" required></textarea>

                    <button class="btn btn-primary btn-sm">Update</button>
                    <button class="btn btn-link btn-sm" type="button" @click="editing = false">Cancel</button>
                </form>
            </div>
            <div v-else v-html="body"></div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <div v-if="authorize('updateReply', reply)">
                <button class="btn" @click="editing = true">Edit</button>
                <button class="btn btn-danger btn-sm" @click="destroy">Delete</button>
            </div>
            <button class="btn btn-sm btn-outline-primary ml-auto" @click="markBestReply" v-if="!isBest">Best Reply?</button>
        </div>
    </div>

</template>

<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        name: 'NewReply',

        props: ['data'],

        components: {Favorite},

        data() {
            return {
                id: this.data.id,
                editing: false,
                body: this.data.body,
                isBest: this.data.isBest,
                reply: this.data
            }
        },

        computed: {
            ago() {
                return moment(this.data.created_at).fromNow()+'...';
            },

        },

        created () {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                })
                .catch(error => {
                    flash(error.response.data, 'danger');
                });

                this.editing = false;
                flash('Updated.');
            },

            destroy() {
                axios.delete('/replies/'+this.data.id);
                     this.$emit('deleted', this.data.id);
            },

            markBestReply () {
                axios.post('/replies/' + this.id + '/best-reply');

                window.events.$emit('best-reply-selected', this.id);
            }
        }
    }
</script>
