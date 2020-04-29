<template>
    <div :id="'reply-'+id" class="card my-3 ">
        <div class="card-header" :class="isBest ? 'text-success' : ''">
            <a :href="'/profiles/+reply.owner.name'" class="flex" v-text="reply.owner.name">
            </a> said <span v-text="ago"></span>

            <favorite :reply="reply" v-if="signedIn"></favorite>
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

        <div class="card-footer d-flex justify-content-between" v-if="authorize('owns', reply) || authorize('owns', reply.thread)">
            <div v-if="authorize('owns', reply)">
                <button class="btn" @click="editing = true">Edit</button>
                <button class="btn btn-danger btn-sm" @click="destroy">Delete</button>
            </div>
            <button class="btn btn-sm btn-outline-primary ml-auto" @click="markBestReply" v-if="authorize('owns', reply.thread)">Best Reply?</button>
        </div>
    </div>

</template>

<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        name: 'NewReply',

        props: ['reply'],

        components: {Favorite},

        data() {
            return {
                id: this.reply.id,
                editing: false,
                body: this.reply.body,
                isBest: this.reply.isBest,
            }
        },

        computed: {
            ago() {
                return moment(this.reply.created_at).fromNow()+'...';
            },

        },

        created () {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.id, {
                    body: this.body
                })
                .catch(error => {
                    flash(error.response.reply, 'danger');
                });

                this.editing = false;
                flash('Updated.');
            },

            destroy() {
                axios.delete('/replies/'+this.id);
                     this.$emit('deleted', this.id);
            },

            markBestReply () {
                axios.post('/replies/' + this.id + '/best-reply');

                window.events.$emit('best-reply-selected', this.id);
            }
        }
    }
</script>
