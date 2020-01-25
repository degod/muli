<template>
    <div id="whole">
        <div id="hanged" :style="bg_img">
            <div class="container">
                <div id="smaller-whole">
                    <div id="white-whole">
                        <img :src="muli_logo"/>
                        <h4>ObinnaPro Company</h4>
                        <div class="div1">
                            <p v-if="errors.length">
                                <b>Please correct the following error(s):</b>
                            </p>
                            <form id="app" @submit="checkForm" action="/do-login" method="post">
                                <input type="text" id="email" class="form-control" v-model="userData.email" placeholder="Username or email" v-on:keyup="checkForm"/>
                                <input type="password" id="password" class="form-control" v-model="userData.password" placeholder="Password" v-on:keyup="checkForm"/>

                                <router-link id="forgot" to="/forgot">
                                    Forgot your password?
                                </router-link>
                                
                                <button id="login-btn" v-bind:class="dClass" v-on:click="submitForm">
                                    LOGIN
                                </button>
                            </form>
                        </div>
                        <div class="div2">
                            <button id="g-btn">
                                <img :src="g_btn"/>
                                Login with Google
                            </button>
                            <button id="f-btn">
                                <img :src="f_btn"/>
                                Login with Facebook
                            </button>
                        </div>
                    </div>
                </div>
                <p>&copy; Copyright 2019 -- This file cannot be shared --- Design by @ObinnaPro</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
        },
        data() {
            return {
                g_btn: "./imgs/google_icon@2x.png",
                f_btn: "./imgs/FB@2x.png",
                bg_img: "background-image: url('./imgs/background-object@2x.png')",
                muli_logo: "./imgs/muli-logo.png",
                userData: {
                    email: '',
                    password: '',
                },
                errors: [],
                loginBtn: "",
                dClass: "inact-btn",
            };
        },
        methods:{
            checkForm: function (e) {
                if (this.userData.email!=='' && this.userData.password!=='') {
                    this.dClass = "act-btn";
                }else{
                    this.dClass = "inact-btn";
                }
                e.preventDefault();
            },
            submitForm: function (e) {
                if (this.userData.email!=='' && this.userData.password!=='') {
                    this.$router.push('/index');
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    @import './resources/assets/sass/_variables.scss';

    div#whole {
        height: 100vh;
        width: 100vw;
        background-image: linear-gradient(to bottom, $lightBlue, $darkBlue) !important;
    }
    #hanged {
        height: 100vh;
        width: 100vw;
        padding-top: 5vh;
        background-position: right top;
        background-size: 75vh;
        background-repeat: no-repeat;
    }
    #smaller-whole{
        height: 550px;
        width: 680px;
        border-radius: 15px;
        margin: 0 auto 0 auto;
        background-image: linear-gradient(to bottom, $darkBlue, $lightBlue) !important;
        padding-top: 80px;
    }
    #white-whole{
        height: 380px;
        width: 400px;
        border-radius: 15px;
        margin: auto;
        background-color: $white;
        text-align: center;
        padding: 25px;

    }
    #white-whole img{
        height: 50px;
    }
    #white-whole h4{
        color: $black;
        font-family: 'Montserrat-Medium', sans-serif;
        font-size: 1.3em;
        padding-top: 6px;
    }
    #white-whole .div1{
        width: 280px;
        padding: 9px;
        text-align: center;
        margin: 0 auto 0 auto;
    }
    .form-control {
        border: 1px solid $ash !important;
        border-radius: 4px;
        padding: 9px;
        margin: 10px auto 15px auto !important; 
        z-index: 999999 !important;
        font-size: .8em;
        color: $formColor;
        outline: none !important;
    }
    #forgot{
        float: right !important;
        color: $textColor;
        font-size: .75em;
        margin-top: -7px;
    }
    #login-btn {
        width: 90%;
        border-radius: 23px;
        font-size: .7em;
        padding: 9px;
        margin-top: 15px;
        outline: none;
    }
    .inact-btn {
        background-color: $ash;
        color: $white;
    }
    .act-btn {
        background-color: $darkBlue;
        color: $white;
    }
    #white-whole .div2{
        width: 300px;
        padding: 9px;
        text-align: justify;
        margin: 0 auto 0 auto;
    }
    .div2 button {
        width: 130px;
        border-radius: 22px;
        background-color: $white;
        box-shadow: -1px 1px 5px 1px $ash;
        border: none;
        font-size: .6em;
        height: 30px;
        outline: none;
    }
    .div2 button img {
        height: 15px !important;
    }
    #g-btn {
        float:left;
    }
    #f-btn {
        float:right;
    }
    #whole .container p {
        margin-top: 12vh;
        text-align: center;
        color: $white;
        font-size: .7em;
    }
</style>
