<template>
    <div id="whole">
        <div class="container">
            <div id="smaller-whole">
                <div id="head">
                    <img :src="muli_logo"/>
                    <div id="head-right">
                        <ul type="none">
                            <li><router-link to="/index">Upload Product</router-link></li>
                            <li><router-link to="/store">Store</router-link></li>
                            <li><router-link to="/">Logout</router-link></li>
                            <li>
                                <div id="cart-icon">
                                    <img :src="cart_icon"/>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="body">
                    <h4>My Shopping Cart</h4>
                    <div id="product-image">
                        <div class="p-img-sect">
                            <div class="row">
                                <div class="col-4">
                                    <img :src="up_img_hold" id="img-hold"/>
                                </div>
                                <div class="col-8">
                                    <div class="row small-img">
                                        <div class="col-12">
                                            <p id="prod-name"> {{ prod_name }} </p>
                                            <p id="prod-desc"> {{ prod_desc }} </p>
                                            
                                            <div class="row">
                                                <div class="col-5">
                                                    <b id="total"> ₦{{ formatCurrency(total) }} </b>
                                                </div>
                                                <div class="col-7" align="right">
                                                    <div id="qty-ctrl">
                                                        Qty:
                                                        
                                                        <img :src="btn_minus" v-on:click="minusQty"/>
                                                        <input v-model="qty" readonly/>
                                                        <img :src="btn_plus" v-on:click="plusQty"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <h4>Cart Summary</h4>
                    <div id="product-desc">
                        <div id="p-desc">
                            <p class="summary">
                                Sub Total ({{ qty }} item(s))
                                <span>₦ {{ formatCurrency(total) }}</span>
                            </p>
                            <p class="summary">
                                Shipping
                                <span>₦ {{ formatCurrency(shipping) }}</span>
                            </p>
                            <hr>
                            <p class="summary summary-all">
                                <b>
                                    Total
                                    <span>₦ {{ formatCurrency(total_all) }}</span>
                                </b>
                            </p>
                        </div>
                    </div>
                    <button id="up-btn" v-on:click="submitNow">
                        Checkout
                    </button>
                </div>
            </div>
            <p id="foot">&copy; Copyright 2019 -- This file cannot be shared --- Design by @ObinnaPro</p>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            var item = JSON.parse(localStorage.getItem('cartItem'));
            console.log(item);
            if(item=="" || item==null){
                this.$router.push('/404');
            }else{
                this.up_img_hold = item.display_img,
                this.qty = item.qty,
                this.price = item.price,
                this.total = item.total,
                this.prod_name = item.prod_name,
                this.prod_desc = item.prod_desc;
                localStorage.removeItem('cartItem');
    
                this.total = this.qty*this.price;
                this.shipping = 500;
                if(this.qty == 1)
                    this.shipping = 500;
                else {
                    var extra = this.qty - 1;
                    this.shipping = 500 + (extra*250);
                }
                this.total_all = this.total+this.shipping;
            }
        },
        data() {
            return {
                muli_logo: "./imgs/muli-logo-white@2x.png",
                cart_icon: "./imgs/shopping-cart.svg",
                up_img_hold: "./imgs/Place-holder@2x.png",
                btn_minus: "./imgs/minusi-icon@2x.png",
                btn_plus: "./imgs/plus-icon@2x.png",
                cart_btn: "./imgs/view_more button@2x.png",
                rated: "Most Rated",
                qty: 1,
                price: 20000,
                total: 20000,
                total_all: 20500,
                shipping: 500,
                prod_name: "Air Max 270",
                prod_desc: "Everything in this email and any attachments relating to the official business ofStanbic IBTC Pension Managers Limited is proprietary to the group. It is confidential, legally privileged and protected by law. We do not own and endorse any other content. The person addressed in the email is the sole authorized recipient. Please notify the sender immediately if it has unintentionally reached you and do not read disclose or use the content in any way.",
                errors: [],
            };
        },
        methods:{
            minusQty: function (e) {
                if (this.qty > 1) {
                    this.qty -= 1;
                    this.total = this.qty*this.price;
                    this.shipping = 500;
                    if(this.qty == 1)
                        this.shipping = 500;
                    else {
                        var extra = this.qty - 1;
                        this.shipping = 500 + (extra*250);
                    }
                    this.total_all = this.total+this.shipping;
                }
            },
            plusQty: function (e) {
                if (this.qty < 9) {
                    this.qty += 1;
                    this.total = this.qty*this.price;
                    this.shipping = 500;
                    if(this.qty == 1)
                        this.shipping = 500;
                    else {
                        var extra = this.qty - 1;
                        this.shipping = 500 + (extra*250);
                    }
                    this.total_all = this.total+this.shipping;
                }
            },
            submitNow: function (e) {
                this.$router.push('/404');
            },
            formatCurrency: function (value) {
                let val = (value/1);
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
        background: $darkBlue;
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
        color: $white;
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
    #img-hold {
        height: 220px !important;
        margin-right: -15px;
    }
    #p-details {
        margin-top: 10px;
    }
    #body #product-desc {
        border-radius: 15px;
        height: 135px;
        width: 100%;
        box-shadow: 0 0 7px 3px $semiWhite;
        margin: 10px auto 10px auto;
        padding: 15px 22px 10px 22px;
    }
    #body #product-desc h4 {
        margin-bottom: 14px;
    }
    .small-img {
        padding-left: 20px; 
    }
    #qty-ctrl {
        height: 40px;
        width: 180px;
        display: inline-block;
        text-align: right;
        padding-top: 3px;
    }
    #qty-ctrl img {
        height: 30px;
        margin-left: 10px;
        margin-right: 10px;
        cursor: pointer;
    }
    #qty-ctrl input {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        text-align: center;
        border: 1px solid #ACACAC;
        outline: none;
    }
    #prod-name {
        text-transform: uppercase;
        font-family: 'Montserrat-Bold', sans-serif;
        font-size: 2.4em;
        margin-bottom: 0px;
    }
    #prod-desc {
        margin-top: 0px;
        font-size: .8em;
        line-height: 15px;
    }
    #total {
        font-family: 'Montserrat-Medium', sans-serif;
        font-size: 1.9em;
        font-weight: bold;
    }
    .summary {
        margin-top: 0px;
        margin-bottom: 0px;
    }
    .summary span {
        float: right;
    }
    .summary-all {
        font-family: 'Montserrat-Bold', sans-serif;
        font-size: 1.1em;
        font-weight: bold;
        text-transform: capitalize !important;
    }
    #up-btn {
        font-family: 'Montserrat-Medium', sans-serif;
        font-size: .9em;
        border-radius: 25px;
        width: 120px;
        background-color: $darkBlue;
        color: $white;
        float: right;
        margin-top: 10px;
        padding: 10px;
        outline: none;
    }
    #foot {
        margin-top: 7vh;
        text-align: center;
        color: $formColor;
        font-size: .75em;
    }
</style>
