<template>
    <div class="col-md-8">
        <div v-if="signedIn">
            <div class="form-group">
                <textarea
                    name="body"
                    class="form-control"
                    rows="5"
                    placeholder="Have something to say?"
                    v-model="body"></textarea>
            </div>

            <div class="form-group">
                <button class="btn btn-default" type="submit" @click="addReply">Post</button>
            </div>
        </div>


        <p class="text-center" v-else>
            You have to <a href="/login">login</a> to participate in this discussion.
        </p>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                body: '',
            }
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', { body: this.body })
                .then (response => {
                    this.body = '';

                    flash('Your reply has been left.');

                    this.$emit('created', response.data);
                })
                .catch(error => {
                    flash(error.response.data, 'danger');
                })
            }
        }
    }
</script>
