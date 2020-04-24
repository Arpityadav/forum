<template>
    <div class="col-md-8">
        <div v-if="signedIn">
            <div class="form-group">
                <textarea
                    name="body"
                    id="body"
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
    import Tribute from "tributejs";

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

        mounted() {
            let tribute = new Tribute({
                // column to search against in the object (accepts function or string)
                lookup: 'value',

                // column that contains the content to insert by default
                fillAttr: 'value',

                values: function(query, cb) {
                    axios.get('/api/users', {params: {name: query}} )
                        .then(function(response){
                            console.log(response);
                            cb(response.data);
                        });
                },

        });

        tribute.attach(document.querySelectorAll("#body"));
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
            },
        }
    }
</script>
