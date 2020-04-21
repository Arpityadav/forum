<template>
    <input type="file" accept="image/*" @change="onChange">
</template>

<script>
    export default {


        methods: {
            onChange (e) {
                if (!e.target.files.length) return;

                let file = e.target.files[0];

                let reader = new FileReader;

                reader.readAsDataURL(file);

                reader.onload = (e) => {
                    this.$emit('loaded', {
                        src: e.target.result,
                        file
                    });
                }
            }
        }
    }
</script>
