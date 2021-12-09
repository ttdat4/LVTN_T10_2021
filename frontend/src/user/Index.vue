<template>
  <v-container fluid class="index">
    <v-row>
      <!-- <v-col cols="12" sm="2">
          <v-sheet rounded="lg" min-height="268">
            Sẽ có những gì ở đây
          </v-sheet>
        </v-col> -->

      <v-col cols="12" sm="12">
        <v-carousel>
          <v-carousel-item
            v-for="(item, i) in items"
            :key="i"
            :src="item.src"
            reverse-transition="fade-transition"
            transition="fade-transition"
          ></v-carousel-item>
        </v-carousel>
      </v-col>

      <!-- <v-col cols="12" sm="3">
          <v-sheet rounded="lg" min-height="268">
            Và những gì ở đây nữa
          </v-sheet>
        </v-col> -->
    </v-row>
    <v-col cols="12" sm="12">
      <v-sheet class="mx-auto" max-width="900">
        <v-slide-group multiple show-arrows>
          <v-slide-item
            v-for="n in listCategory"
            :key="n"
            v-slot="{ active, toggle }"
          >
            <v-btn
              class="mx-2"
              :input-value="active"
              active-class="blue white--text"
              depressed
              rounded
              @click="toggle"
            >
              {{ n.name }}
            </v-btn>
          </v-slide-item>
        </v-slide-group>
      </v-sheet>
    </v-col>
    <v-row> </v-row>

    <v-row>
      <h3 class="ml-16 mt-16">Sản phẩm mới</h3>
      <v-col>
        <v-sheet class="mx-auto" elevation="0">
          <v-slide-group class="pa-4" show-arrows>
            <v-slide-item v-for="item in listProduct" :key="item.id" >
           
              <v-card class="ma-1" height="450" width="400">
                <Product
                  :product="item"
                />
              </v-card>
            </v-slide-item>
          </v-slide-group>
        </v-sheet>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import Product from "../components/Product.vue";
export default {
  components: {
    Product,
  },
  data() {
    return {
      listProduct: [], //biến lưu dnah sách sản phẩm
      listCategory: [], //biến lưu danh sách danh mục
      items: [
        {
          src:
            "https://www.bulgari.com/on/demandware.static/-/Library-Sites-bulgariSharedLibrary/default/dw0e0ebb36/homepage/refresh_serpenti/2021/1920x650.jpg",
        },
        {
          src:
            "https://www.graff.com/dw/image/v2/BFNT_PRD/on/demandware.static/-/Library-Sites-GraffSharedLibrary/en_GL/dw5e4c2094/02TildasBow_Campaign-Page_Desktop.jpg",
        },
      ],
    };
  },
  mounted() {
    this.axios
      .get("http://127.0.0.1:8000/api/category")
      .then((response) => {
        this.listCategory = response.data;
        
      })
      .catch((error) => {
        this.message = error;
      });
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

<style lang="scss" scoped></style>
