<template>
  <v-container fluid class="index">
    <v-row>
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
    </v-row>
    <v-col cols="12" sm="12" id="listCategorySlide">
      <v-sheet class="mx-auto" max-width="900">
        <v-slide-group multiple show-arrows>
          <v-slide-item v-for="n in listCategory" :key="n" v-slot="{ active }">
            <v-btn
              :id="activeCategory == n.id ? 'activeCategory' : ''"
              class="mx-2"
              :input-value="active"
              active-class="blue white--text"
              depressed
              rounded
              @click="toggle(n)"
            >
              {{ n.name }}
            </v-btn>
          </v-slide-item>
        </v-slide-group>
      </v-sheet>
    </v-col>

    <v-row>
      <h3 class="ml-16 mt-16">Sản phẩm mới</h3>
      <v-col v-for="item in listProduct" :key="item.id">
        <v-card class="ma-3" height="450" width="400">
          <Product :product="item" />
        </v-card>
      </v-col>
      <div class="text-center">
        <v-pagination
          v-model="page"
          :length="15"
          :total-visible="6"
          @changePage="onChangePage"
        ></v-pagination>
      </div>
      <!-- <div class="card-footer pb-0 pt-3">
          <jw-pagination
            :items="exampleItems"
            @changePage="onChangePage"
            :labels="customLabels"
          ></jw-pagination>
        </div> -->
    </v-row>

    <v-row>
      <v-col> </v-col>
    </v-row>
  </v-container>
</template>

<script>
import Product from "../components/Product.vue";

// const exampleItems = [...Array(50).keys()].map((i) => ({

// }));
// const customLabels = {
//     first: '<<',
//     last: '>>',
//     previous: '<',
//     next: '>'
// };
export default {
  components: {
    Product,
  },
  data() {
    return {
      // exampleItems,
      // customLabels,
      pagination: {
        current: 1,
        total: 0,
      },
      activeCategory: "",
      listProduct: [], //biến lưu danh sách sản phẩm
      listCategory: [], //biến lưu danh sách danh mục
      items: [
        {
          src:
            "https://skymond.vn/uploads/files/Banner%20nhan%20cuoi%20vang%20trang.jpg",
        },
        {
          src:
            "https://trangsuc123.com/wordpress/uploads/banner12.jpg",
        },
      ],
    };
  },

  mounted() {
    this.axios
      .get("http://127.0.0.1:8000/api/findCaPro")
      .then((response) => {
        this.listCategory = response.data.data;
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
      this.getProducts();
  },
  methods: {
    toggle(item) {
      this.activeCategory = item.id;
      this.axios
        .get("http://127.0.0.1:8000/api/find/" + item.id)
        .then((response) => {
          if (response.data.data.length > 0) {
            this.$store.dispatch("getProductCategory", response.data.data);
            this.$router.push("/productcategory");
          } else {
            this.$router.push("/notfound");
          }
        });
    },
    getProducts() {
            window.axios.get('/api/product?page=' + this.pagination.current)
                .then(response => {
                    this.listProduct = response.data.product;
                    this.pagination.current = response.data.current_page;
                    this.pagination.total = response.data.last_page;
                });
        },
        onPageChange() {
            this.getProducts();
        }
  },
};
</script>

<style lang="scss" scoped>
#activeCategory {
  background-color: rgb(111, 111, 226);
  color: white;
}
#listCategorySlide {
  margin-left: 150px;
}
</style>
