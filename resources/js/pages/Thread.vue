<script>
    import Replies from '../components/Replies.vue';
    import SubscriptionButton from '../components/SubscriptionButton.vue';

    export default {
        components: { Replies, SubscriptionButton },

        props: ['thread'],

        data () {
            return {
                repliesCount: this.thread.replies_count,
                locked: this.thread.locked,
                editing: false,
                title: this.thread.title,
                body: this.thread.body,
                form: {}
            }
        },

        created () {
            this.resetForm();
        },

        methods: {
            lock () {
                axios[this.locked ? 'delete' : 'post']('/lock-thread/' + this.thread.slug);

                this.locked = ! this.locked;
            },

            update () {
                let uri = `/threads/${this.thread.channel.slug}/${this.thread.slug}`;
                
                axios.patch(uri, this.form)
                    .then(() => {
                        this.editing = false;

                        this.title = this.form.title;
                        this.body = this.form.body;

                        flash('Your thread has been updated.');
                })
            },

            resetForm () {
                this.form = {
                    title: this.title,
                    body: this.body,
                };
                this.editing = false;
            }
        }
    }
</script>
