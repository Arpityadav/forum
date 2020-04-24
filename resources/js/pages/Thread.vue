<script>
    import Replies from '../components/Replies.vue';
    import SubscriptionButton from '../components/SubscriptionButton.vue';

    export default {
        components: { Replies, SubscriptionButton },

        props: ['initialRepliesCount'],

        data() {
            return {
                repliesCount: this.initialRepliesCount,
            }
        }
    }
</script>
