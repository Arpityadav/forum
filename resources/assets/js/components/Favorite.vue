<template>
    <button type="submit" :class="classes" @click="toggle">
        <i class="fas fa-heart"></i>
        {{ count }}
    </button>
</template>

<script>
    export default {
        props: ['reply'],

        data() {
            return {
                count: this.reply.favoritesCount,
                active: this.reply.isFavorited
            }
        },

        computed: {
            classes(){
                return ['btn', this.active ? 'btn-primary' : 'btn-default'];
            },

            endpoint() {
                return '/replies/' + this.reply.id + '/favorites';
            }
        },

        methods: {
            toggle() {
                if(this.active) {
                    this.destroy();
                }else{
                    this.create();
                }
            },

            destroy() {
                axios.delete(this.endpoint);

                this.active = false;
                this.count--;
            },
            create() {
                axios.post(this.endpoint);

                this.active = true;
                this.count++;
            }
        }
    }
</script>
