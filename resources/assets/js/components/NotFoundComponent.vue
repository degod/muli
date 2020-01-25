<template>
    <div id="whole">
        <div class="container">
            <img :src="muli_logo" id="only-img" v-on:click="startNow"/>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
        },
        data() {
            return {
                muli_logo: "./imgs/no-product-found@2x.png",
                errors: [],
            };
        },
        methods:{
            startNow: function (e) {
                this.$router.push('/index');
            }
        }
    }
</script>

<style scoped lang="scss">
    @import './resources/assets/sass/_variables.scss';

    div#whole {
        height: 100vh;
        width: 100vw;
        background-color: $white;
    }
    .container {
        padding-top: 35vh;
        text-align: center;
    }
    #only-img {
        height: 30vh;
    }
</style>
