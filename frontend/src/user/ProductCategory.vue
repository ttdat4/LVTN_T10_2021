<template>
  <v-container>
    <v-toolbar-title><span style="font-weight:bold">Danh sách sản phẩm theo: {{listProduct[0].category.name}}</span></v-toolbar-title>
    <v-row >
      
      <v-col cols="12" sm="4"  v-for="product in listProduct"
          :key="product.id">
        <Product
          :product="product"
        />
      </v-col>
    </v-row>
   
        
    
  </v-container>
</template>

<script>
import Product from "../components/Product.vue";
export default {
  components: { Product },
  computed: {
    listProduct() {
      return this.$store.state.listProduct;
    },
  },
};
</script>

<style scoped></style>
