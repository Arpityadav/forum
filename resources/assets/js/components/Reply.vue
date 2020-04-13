<template>

    <div :id="'reply-'+id" class="card my-3">
        <div class="card-header">
            <a :href="'/profiles/+data.owner.name'" class="flex" v-text="data.owner.name">
            </a> said <span v-text="ago"></span>

            <favorite :reply="data" v-if="signedIn"></favorite>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <textarea class="form-control" v-model="body"></textarea>

                <button class="btn btn-primary btn-sm" @click="update">Update</button>
                <button class="btn btn-link btn-sm" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>

        <div class="card-footer" v-if="canUpdate">
            <button class="btn" @click="editing = true">Edit</button>
            <button class="btn btn-danger btn-sm" @click="destroy">Delete</button>
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
            }
        },

        computed: {
            ago() {
                return moment(this.data.created_at).fromNow()+'...';
            },

            signedIn() {
                return window.App.signedIn;
            },

            canUpdate() {
                return this.authorize(user => user.id == this.data.user_id);
            }
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
            }
        }
    }
</script>
