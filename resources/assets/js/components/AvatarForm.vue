<template>
    <div>
        <div class="level mb-2">
            <h3 v-text="user.name" class="mr-2"></h3>
            <img :src="avatar" :alt="user.name" width="50" height="50">
        </div>

        <form method="POST" enctype="multipart/form-data" v-if="canUpdate">
            <image-upload name="avatar" @loaded="onLoad"></image-upload>
        </form>


    </div>
</template>

<script>
    import ImageUpload from './ImageUpload.vue'

    export default {
        props: ['user'],

        components: { ImageUpload },

        data () {
            return {
                avatar: this.user.avatar_path
            }
        },

        computed: {
            canUpdate () {
                return this.authorize(user => user.id === this.user.id);
            }
        },

        methods: {

            onLoad (avatar) {
                this.avatar = avatar.src;

                this.persist(avatar.file);
            },

            persist (avatar) {
                let data = new FormData;

                data.append('avatar', avatar);

                axios.post('/api/users/' + this.user.name + '/avatar', data)
                    .then(() => flash('Avatar uploaded!') );
            }
        }

    }
</script>
