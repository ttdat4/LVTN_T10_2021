<template>
  <v-hover v-slot="{ hover }">
    <router-link  :to="{ name: 'ProductDetails', params: { url: product.id } }" style="text-decoration:none">
    <v-card
      height="450"
      :elevation="hover ? 16 : 2"
      :class="{ 'on-hover': hover }"
      class="mx-auto"
    >
      <v-img height="300" :aspect-ratio="16 / 9" :src="product.image[0].urlimg" >
        <v-expand-transition>
          <div
            v-if="hover"
            class="d-flex transition-fast-in-fast-out blue darken-2 v-card--reveal text-h4 white--text"
            style="height: 100%;"
          >
            {{ product.price.toLocaleString() }} vnđ
          </div>
        </v-expand-transition>
      </v-img>
      <v-card-text class="pt-6" style="position: relative;">
        
        <v-btn absolute color="blue" class="white--text" fab large right top >
          info
        </v-btn>
       
        <v-btn
          class="text-h6 font-weight-light blue--text mb-2"
        >
          {{ product.name }}
        </v-btn>
        <v-rating
          v-model="rating"
          background-color="yellow"
          color="yellow accent-4"
          dense
          half-increments
          hover
          size="30"
        ></v-rating>

        <div class="font-weight-light text-h6 mb-2">
          {{ product.description }}
        </div>
      </v-card-text>
    </v-card>
     </router-link>
  </v-hover>
</template>

<script>
export default {
  
  name: "product",
  props: ["product"],
  methods:{
     addCart(){
      const cartItem = {
        id: this.product.id,
        name: this.product.name,
        img: this.product.image[0].urlimg,
        price: this.product.price,
        quanlity: parseInt(1),
      };
      this.$store.dispatch("addProductToCart", cartItem);
      this.$swal("Đã thêm vào giỏ thành công!");
    },
    productDetails(){

    }
  }
};
</script>

<style lang="scss" scoped>
.v-card--reveal {
  align-items: center;
  bottom: 0;
  justify-content: center;
  opacity: 0.5;
  position: absolute;
  width: 100%;
}
.v-card .on-hover.theme--dark {
  background-color: rgba(#fff, 0.8);
}
.v-card__text {
  color: #000;
}
</style>
