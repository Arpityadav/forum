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
            }
        },

        methods: {
            lock () {
                axios[this.locked ? 'delete' : 'post']('/lock-thread/' + this.thread.slug);

                this.locked = ! this.locked;
            }
        }
    }
</script>
