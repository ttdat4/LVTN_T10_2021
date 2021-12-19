<template>
  <v-container>
    <v-toolbar-title><span style="font-weight:bold">Tất cả sản phẩm </span></v-toolbar-title>
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
  data() {
    return {
      listProduct: [],
    };
  },
  mounted() {
    this.axios
      .get("http://127.0.0.1:8000/api/product")
      .then((response) => {
        this.listProduct = response.data.product;
      })
      .catch((error) => {
        this.message = error;
      });
  },
};
</script>

<style scoped></style>
