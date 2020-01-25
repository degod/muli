<template>
    <div id="whole">
        <div class="container">
            <div id="smaller-whole">
                <div id="head">
                    <img :src="muli_logo"/>
                    <div id="head-right">
                        <ul type="none">
                            <li class="active">Upload Product</li>
                            <li><router-link to="/store">Store</router-link></li>
                            <li><router-link to="/">Logout</router-link></li>
                            <li>
                                <router-link to="/cart">
                                    <div id="cart-icon">
                                        <img :src="cart_icon"/>
                                    </div>
                                </router-link>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="body">
                    <div id="product-image">
                        <h4>Product Image</h4>
                        <div class="p-img-sect">
                            <div class="row">
                                <div class="col-4">
                                    <img :src="(front) ? makeImg(front) : up_img_hold" @click="$refs.file1.click()"/>
                                    <input type="file" style="display:none" accept="image/*" ref="file1" v-on:change="updateImg('f', $event)"/>
                                </div>
                                <div class="col-8">
                                    <div class="row small-img">
                                        <div class="col-4">
                                            <img :src="(rear) ? makeImg(rear) : up_img_hold" @click="$refs.file2.click()"/>
                                            <input type="file" style="display:none" accept="image/*" ref="file2" v-on:change="updateImg('r', $event)"/>
                                        </div>
                                        <div class="col-4">
                                            <img :src="(left) ? makeImg(left) : up_img_hold" @click="$refs.file3.click()"/>
                                            <input type="file" style="display:none" accept="image/*" ref="file3" v-on:change="updateImg('l', $event)"/>
                                        </div>
                                        <div class="col-4">
                                            <img :src="(right) ? makeImg(right) : up_img_hold" @click="$refs.file4.click()"/>
                                            <input type="file" style="display:none" accept="image/*" ref="file4" v-on:change="updateImg('t', $event)"/>
                                        </div>
                                    </div>
                                    <div id="p-details" class="row">
                                        <div class="col-6">
                                            <input class="form-control" placeholder="Product Name" v-model="p_name"/>
                                        </div>
                                        <div class="col-3">
                                            <input class="form-control" placeholder="Qty" v-model="qty"/>
                                        </div>
                                        <div class="col-3">
                                            <input class="form-control" placeholder="Price" v-model="price"/>
                                        </div>
                                    </div>
                                    <div id="p-radios" class="row">
                                        <div class="col-4">
                                            <input type="radio" name="period" v-on:click="switchPeriod('most')"/>
                                            Most rated
                                        </div>
                                        <div class="col-4">
                                            <input type="radio" name="period" v-on:click="switchPeriod('best')"/>
                                            Best selling
                                        </div>
                                        <div class="col-4">
                                            <input type="radio" name="period" v-on:click="switchPeriod('newest')"/>
                                            New Arrival
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="product-desc">
                        <h4>Product Description</h4>
                        <div id="p-desc">
                            <textarea class="form-control" v-model="desc"></textarea>
                        </div>
                        <button id="up-btn" v-on:click="uploadProduct">
                            UPLOAD
                        </button>
                    </div>
                </div>
            </div>
            <p>&copy; Copyright 2019 -- This file cannot be shared --- Design by @ObinnaPro</p>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        mounted() {
        },
        data() {
            return {
                muli_logo: "./imgs/muli-logo-white@2x.png",
                cart_icon: "./imgs/shopping-cart@2x.png",
                up_img_hold: "./imgs/Place-holder@2x.png",
                upBtn: '',
                period: '',
                p_name: '',
                qty: '',
                price: '',
                desc: '',
                front: "",
                rear: "",
                left: "",
                right: "",
                errors: [],
            };
        },
        methods:{
            submitForm: function (e) {
                if (this.userData.email!=='' && this.userData.password!=='') {
                    this.$router.push('/index');
                }
            },
            updateImg: function (g, e) {
                switch(g) {
                    case 'f':
                        this.front = '';
                        this.front = e.target;
                        break;
                    case 'r':
                        this.rear = '';
                        this.rear = e.target;
                        break;
                    case 'l':
                        this.left = '';
                        this.left = e.target;
                        break;
                    case 't':
                        this.right = '';
                        this.right = e.target;
                        break;
                }
            },
            makeImg: function(v){
                return URL.createObjectURL(v.files[0])
            },
            switchPeriod: function(v) {
                this.period = v;
            },
            uploadProduct: function() {
                const URL = window.location.pathname+'api/upload-product';
                if(this.period!='' && this.p_name!='' && this.qty!='' && this.price!='' && this.desc!='' && this.front!='' && this.rear!='' && this.left!='' && this.right!=''){
                    const DATA = new FormData();
                    DATA.append('p_name', this.p_name);
                    DATA.append('desc', this.desc);
                    DATA.append('qty', this.qty);
                    DATA.append('price', this.price);
                    DATA.append('period', this.period);
                    DATA.append('front', this.front.files[0], this.front.files[0].name);
                    DATA.append('rear', this.rear.files[0], this.rear.files[0].name);
                    DATA.append('left', this.left.files[0], this.left.files[0].name);
                    DATA.append('right', this.right.files[0], this.right.files[0].name);
                    axios.post(URL, DATA).then(response => {
                        var msg = (response.data.result!=undefined) ? response.data.result : ((response.data.error!=undefined) ? response.data.error : "Oops! A fatal error has occured.");
                        flash(msg, 'error');
                        if(msg == "Upload Successful"){
                            this.$router.push('/store');
                        }
                        console.log("RESPONSE: ",response);
                    });
                }else{
                    flash('Some fields might still be empty!', 'error');
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
        background-color: $white;
    }
    #smaller-whole{
        height: 600px;
        width: 680px;
        margin: 0 auto 0 auto;
        background-color: $white;
    }
    #head {
        box-shadow: 0 0 5px 2px $semiWhite;
        background-color: $darkBlue;
        height: 50px;
        border-radius: 24px;
        margin: 10px auto 15px auto;
    }
    #head img {
        height: 42px;
        margin: 5px auto 5px 50px;
    }
    #head-right {
        height: 42px;
        background-color: $white;
        height: 50px;
        width: 50%;
        float: right;
        border-radius: 24px;
        margin-right: -3px;
        box-shadow: 5px 3px 10px 1px $semiWhite;
    }
    #head-right ul {
        margin: 15px auto 15px auto;
    }
    #head-right ul li{
        float: left;
        margin-right: 9.6px;
        margin-left: 9.6px;
        font-family: 'Montserrat-Medium', sans-serif;
        font-size: .9em;
        color: $textColor;
    }
    #head-right ul li a{
        color: $textColor;
    }
    #head-right ul li.active {
        color: $darkBlue !important;
    }
    #head-right ul li div#cart-icon{
        background: $semiWhite;
        border-radius: 50%;
        height: 30px;
        width: 30px;
        top: -5px;
        position: relative;
        float: right;
    }
    #head-right ul li div#cart-icon img{
        height: 12px;
        left: -42px;
        bottom: -3px;
        position: relative;
    }
    #body {
        border-radius: 15px;
        height: 560px;
        width: 100%;
        color: $textColor;
    }
    #body #product-image {
        border-radius: 15px;
        height: 265px;
        width: 100%;
        box-shadow: 0 0 7px 3px $semiWhite;
        margin: 10px auto 10px auto;
        padding: 15px 22px 10px 22px;
    }
    #body #product-image h4 {
        margin-bottom: 14px;
    }
    .p-img-sect img {
        max-width: 100% !important;
        max-height: 200px;
        margin-right: -15px;
        cursor: pointer;
    }
    .small-img {
        padding: 0px !important;
    }
    .small-img.col-4 {
        margin: 0px !important;
        padding: 0px !important;
    }
    .small-img img {
        max-width: 100%;
        max-height: 120px;
        cursor: pointer;
    }
    #p-details {
        margin-top: 10px;
    }
    #p-radios {
        margin-top: 10px;
        font-size: .9em;
    }
    input[type='radio'] {
        box-sizing: border-box;
        appearance: none;
        background: $white;
        outline: 1px solid $formColor;
        border: 1px solid $white;
        width: 15px;
        height: 15px;
        border-radius: 2px;
        margin-right: 3px;
        cursor: pointer;
        margin-bottom: -3px;
    }
    input[type='radio']:checked {
        background: $darkBlue;
        outline: 1px solid $darkBlue;
    }
    #body #product-desc {
        border-radius: 15px;
        height: 265px;
        width: 100%;
        box-shadow: 0 0 7px 3px $semiWhite;
        margin: 10px auto 10px auto;
        padding: 15px 22px 10px 22px;
    }
    #body #product-desc h4 {
        margin-bottom: 14px;
    }
    textarea {
        border-radius: 5px;
        height: 150px;
        width: 100%;
        resize: none;
    }
    #up-btn {
        border-radius: 25px;
        width: 220px;
        background-color: $darkBlue;
        color: $white;
        float: right;
        margin-top: 10px;
        padding: 5px;
        outline: none;
    }
    #whole .container p {
        margin-top: 7vh;
        text-align: center;
        color: $formColor;
        font-size: .75em;
    }
</style>
