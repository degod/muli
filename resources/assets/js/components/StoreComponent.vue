<template>
    <div id="whole">
        <div class="container">
            <div id="smaller-whole">
                <div id="head">
                    <img :src="muli_logo"/>
                    <div id="head-right">
                        <ul type="none">
                            <li><router-link to="/index">Upload Product</router-link></li>
                            <li class="active">Store</li>
                            <li><router-link to="/">Logout</router-link></li>
                            <li>
                                <router-link to="/cart">
                                    <div id="cart-icon">
                                        <img :src="cart_icon"/>
                                        <div id="cart-count" v-if="cart_item>0">1</div>
                                    </div>
                                </router-link>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="body">
                    <div id="product-data">
                        <div id="product-ash">
                            <div id="display-board">
                                <div id="image-gallery">
                                    <img :src="cart_btn" id="cart-btn" v-on:click="rotateBtn" :class='rotate_class'/>
                                    <div id="side-gallery" :class="slide">
                                        <div class="thumbnail">
                                            <img :src="front" v-on:click="party(front);selected=1" :class="{highlight:selected==1}"/>
                                        </div>
                                        <div class="thumbnail">
                                            <img :src="rear" v-on:click="party(rear);selected=2" :class="{highlight:selected==2}"/>
                                        </div>
                                        <div class="thumbnail">
                                            <img :src="left" v-on:click="party(left);selected=3" :class="{highlight:selected==3}"/>
                                        </div>
                                        <div class="thumbnail">
                                            <img :src="right" v-on:click="party(right);selected=4" :class="{highlight:selected==4}"/>
                                        </div>
                                    </div>
                                </div>
                                <img :src="display_img" id="display-img"/>
                            </div>
                            <div id="details">
                                <div id="details-top">
                                    <div id="rated">{{ rated }}</div>
                                    <div id="qty-ctrl">
                                        Qty:
                                        
                                        <img :src="btn_minus" v-on:click="minusQty"/>
                                        <input v-model="qty" readonly/>
                                        <img :src="btn_plus" v-on:click="plusQty"/>
                                    </div>
                                </div>
                                <p id="prod-name"> {{ prod_name }} </p>
                                <p id="prod-desc"> {{ prod_desc }} </p>
                                <div class="row">
                                    <div class="col-5">
                                        <b id="total"> ₦{{ formatCurrency(total) }} </b>
                                    </div>
                                    <div class="col-7" align="right">
                                        <button id="add-to-cart" v-on:click="addToCart">
                                            ADD TO CART
                                        </button>
                                        <button id="buy-now" v-on:click="buyNow">
                                            BUY NOW
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        mounted() {
            const URL = window.location.pathname+'api/get-product';
            axios.get(URL).then(response => {
                var msg = (response.data.result!=undefined) ? response.data.result : ((response.data.error!=undefined) ? response.data.error : "Oops! A fatal error has occured.");
                // flash(msg, 'error');
                console.log("RESPONSE: ",response);
                if(msg == "Pull Successful"){
                    var data = response.data.data;
                    this.prod_name = data.name;
                    this.prod_desc = data.description;
                    this.total = this.price = data.price;
                    this.rated = (data.rating=='most') ? "Most Rated" : ((data.rating=="best") ? "Best Selling" : "New Arrival");
                    this.front = "./imgs/products/"+data.front_img;
                    this.display_img = this.front;
                    this.rear = "./imgs/products/"+data.rear_img;
                    this.left = "./imgs/products/"+data.left_img;
                    this.right = "./imgs/products/"+data.right_img;
                }else{
                    notFound();
                }
            });
        },
        data() {
            return {
                muli_logo: "./imgs/muli-logo-white@2x.png",
                cart_icon: "./imgs/shopping-cart@2x.png",
                up_img_hold: "./imgs/Place-holder@2x.png",
                btn_minus: "./imgs/minusi-icon@2x.png",
                btn_plus: "./imgs/plus-icon@2x.png",
                cart_btn: "./imgs/view_more button@2x.png",
                rated: "Most Rated",
                selected: "1",
                cart_item: 0,
                display_img: "",
                front: this.up_img_hold,
                rear: this.up_img_hold,
                left: this.up_img_hold,
                right: this.up_img_hold,
                qty: 1,
                price: 20000,
                total: 20000,
                prod_name: "Air Max 270",
                prod_desc: "Everything in this email and any attachments relating to the official business ofStanbic IBTC Pension Managers Limited is proprietary to the group. It is confidential, legally privileged and protected by law. We do not own and endorse any other content. The person addressed in the email is the sole authorized recipient. Please notify the sender immediately if it has unintentionally reached you and do not read disclose or use the content in any way.",
                errors: [],
                is_rotate: false,
                rotate_class: "rotate",
                slide: "slide-leave",
            };
        },
        methods:{
            notFound: function () {
                this.$router.push('/404');
            },
            minusQty: function () {
                if (this.qty > 1) {
                    this.qty -= 1;
                    this.total = this.qty*this.price;
                }
            },
            plusQty: function () {
                if (this.qty < 9) {
                    this.qty += 1;
                    this.total = this.qty*this.price;
                }
            },
            addToCart: function () {
                if (localStorage.getItem) {
                    var item = {
                        display_img: this.display_img,
                        qty: this.qty,
                        price: this.price,
                        total: this.total,
                        prod_name: this.prod_name,
                        prod_desc: this.prod_desc
                    }
                    localStorage.setItem('cartItem', JSON.stringify(item));
                    this.cart_item = 1;
                    flash("Product Added to your cart!", 'success');
                }else{
                    flash("Cannot add to cart. Please use a better browser!", 'error');
                }
            },
            buyNow: function () {
                if(this.cart_item > 0){
                    this.$router.push('/cart');
                }else{
                    flash("Kindly add this product to your cart to buy now!", 'error');
                }
            },
            party: function (v) {
                this.display_img = v;
            },
            rotateBtn: function () {
                this.is_rotate = !this.is_rotate;
                if(this.is_rotate === true){
                    this.rotate_class = "rotate active";
                    this.slide = "slide-enter active";
                }else {
                    this.rotate_class = "rotate";
                    this.slide = "slide-leave active";
                }
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
    #cart-count {
        background-color: $red;
        color: $white;
        font-size: .5em;
        border-radius: 50%;
        height: 14px;
        width: 14px;
        text-align: center;
        position: relative;
        padding: 2px;
        top: -22px;
        right: -20px;
    }
    #body {
        border-radius: 15px;
        height: 560px;
        width: 100%;
        color: $textColor;
    }
    #body #product-data {
        border-radius: 18px;
        height: 650px;
        width: 100%;
        margin: 10px auto 10px auto;
        padding: 0px;
        background-color: $darkBlue;
    }
    #body #product-data #product-ash {
        background-color: $semiWhite;
        border-radius: 15px;
        height: 645px;
        width: 100%;
        margin: 10px auto 10px auto;
        padding: 15px 22px 10px 22px;
    }
    #display-board {
        height: 375px;
        text-align: center;
    }
    #display-img {
        max-height: 360px;
    }
    #image-gallery {
        position: relative;
        top: -15px;
        right: -10px;
        float: right;
        overflow: hidden;
    }
    #cart-btn {
        height: 55px;
        position: relative;
        float: right;
        cursor: pointer;
    }
    #details {
        height: 240px;
        background-color: $white;
        border-radius: 20px;
        box-shadow: 0 3px 10px 1px #E1E1E1;
        padding-left: 23px;
        padding-right: 23px;
    }
    #details-top {
        height: 45px;
    }
    #rated {
        height: 40px;
        width: 170px;
        border-radius: 0 0 12px 12px;
        display: inline-block;
        background-color: $red;
        text-align: center;
        text-transform: uppercase;
        font-family: 'Montserrat-Bold', sans-serif;
        padding-top: 10px;
        color: $white;
    }
    #qty-ctrl {
        height: 40px;
        width: 190px;
        display: inline-block;
        text-align: right;
        padding-top: 3px;
        position: relative;
        right: -240px;
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
        border: 1px solid $formColor;
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
    #add-to-cart {
        font-family: 'Montserrat-Bold', sans-serif;
        font-size: .8em;
        border-radius: 25px;
        background-color: $yellow;
        padding: 11px;
        border: none;
        width: 140px;
        color: $textColor;
        outline: none;
    }
    #buy-now {
        font-family: 'Montserrat-Bold', sans-serif;
        font-size: .8em;
        border-radius: 25px;
        background-color: $darkBlue;
        padding: 11px;
        border: none;
        width: 140px;
        margin-left: 10px;
        color: $white;
        outline: none;
    }
    #side-gallery {
        width: 90px;
        height: 330px;
        background-color: $white;
        border-radius: 10px;
        margin-top: 50px;
        padding-top: 5px;
    }
    .thumbnail {
        padding: 5px;
        padding-top: 0;
        margin: 5px 5px 0px 5px;
    }
    .thumbnail img {
        width: 70px;
        cursor: pointer;
    }

    .slide-leave.active, .slide-enter.active {
        transition: .3s;
    }
    .slide-enter {
        transform: translate(0%, 0);
    }
    .slide-leave {
        transform: translate(110%, 0);
    }
    .rotate {
        -webkit-transition-duration: .3s;
        -moz-transition-duration: .3s;
        -o-transition-duration: .3s;
        transition-duration: .3s;
        -webkit-transition-property: -webkit-transform;
        -moz-transition-property: -moz-transform;
        -o-transition-property: -o-transform;
        transition-property: transform;
        outline: 0;
    }
    .rotate.active {
        -webkit-transform: rotate(135deg);
        -moz-transform: rotate(135deg);
        -ms-transform: rotate(135deg);
        -o-transform: rotate(135deg);
        transform: rotate(135deg);
    }

    .highlight{
        border: 2px solid $red;
        border-radius: 4px;
    }
</style>
