<template>
  <v-content id="prodet">
    <v-row justify="space-around">
      <v-col cols="7">
        <v-sheet class="mx-auto" elevation="0" max-width="800">
          <v-slide-group class="pa-4" show-arrows>
            <v-slide-item v-for="(item, i) in product.image" :key="i">
              <v-card class="ma-1" height="300" width="585">
                <v-img
                  max-height="300"
                  max-width="585"
                  :src="item.urlimg"
                ></v-img>
              </v-card>
            </v-slide-item>
          </v-slide-group>
        </v-sheet>
      </v-col>

      <v-col cols="5">
        <v-card-text class="pt-10" style="position: relative;">
          <div class="text-h4 font-weight-light blue--text mb-2">
            {{ product.name }}
          </div>

          <div class="font-weight-light text-h6 mb-2">
            {{ product.description }}
          </div>
          <div class="font-weight-light text-h6 mb-2">
            {{ product.price }}
          </div>
          <div class="font-weight-light text-h6 mb-2">
            Kích thước
          </div>
          <v-row>
            <v-col
              ><v-radio-group v-model="sizeActive" row>
                <v-radio
                  v-for="(item, i) in product.size"
                  :key="i"
                  :label="item.name"
                  :value="item"
                >
                </v-radio> </v-radio-group
            ></v-col>
          </v-row>
          <v-btn
            v-if="sizeActive != ''"
            absolute
            color="blue"
            class="white--text"
            large
            @click="addCart()"
          >
            Thêm vào giỏ hàng
          </v-btn>
          <v-btn
            v-if="sizeActive == ''"
            absolute
            color="grey"
            class="white--text"
            large
            @click="choose()"
          >
            Thêm vào giỏ hàng
          </v-btn>
        </v-card-text>
      </v-col>
    </v-row>

    <v-row>
      <v-tabs v-model="tab" background-color="white" centered icons-and-text>
        <v-tabs-slider></v-tabs-slider>
        <v-tab href="#description">
          Mô tả chi tiết sản phẩm
         
          <v-icon>mdi-heart</v-icon>
        </v-tab>

        <v-tab href="#subscribe">
          Bình luận
          <v-icon>mdi-message</v-icon>
        </v-tab>
      </v-tabs>

      <v-tabs-items v-model="tab">
        <v-tab-item :key="1" value="description">
          <v-card flat>
            <v-row>
              <v-col class="ml-16">
                <v-card-text> {{ product.description }}</v-card-text>
              </v-col>
            </v-row>
          </v-card>
        </v-tab-item>

        <v-tab-item :key="2" value="subscribe">
          <v-card flat>
            <v-row>
              <v-col class="ml-16" cols="8">
                <v-text-field
                  label="Viết bình luận..."
                  :rules="rules"
                  hide-details="auto"
                ></v-text-field>
              </v-col>
              <v-col cols="2" class="mt-4 ml-10">
                <v-btn color="blue" dark>
                  Bình luận
                </v-btn>
              </v-col>
            </v-row>
            <v-row>
              <v-col class="ml-16">
                Bình luận
              </v-col>
            </v-row>
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </v-row>
    <v-row>
      <h3 class="ml-16 mt-16">Sản phẩm cùng loại ở đây nè</h3>
      <v-col>
        <v-sheet class="mx-auto" elevation="0">
          <v-slide-group class="pa-4" show-arrows>
            <v-slide-item v-for="item in sameproduct" :key="item.id" >
           
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
  </v-content>
</template>

<script>
import Product from "../components/Product.vue";
export default {
  name: "ProductDetails",
  components: { Product },
  data: () => ({
    sizeActive: "",
    dialog: false,
    model: null,
    tab: null,
    product: {
      name: "",
      price: 0,
      description: "",
      category: {},
      supplier: {},
      image: [],
      size: [
        {
          name: "",
        },
      ],
      
    },
    sameproduct:[],
    rules: [
      (value) => !!value || "Không được để trống",
      (value) => (value && value.length >= 3) || "Bình luận ít nhất 3 ký tự",
    ],
  }),
  methods: {
    addCart() {
      const cartItem = {
        id: this.product.id,
        name: this.product.name,
        sizeName: this.sizeActive.name,
        sizeId: this.sizeActive.id,
        img: this.product.image[0].urlimg,
        price: this.product.price,
        quanlity: parseInt(1),
      };
      this.$store.dispatch("addProductToCart", cartItem);
      this.$swal("Đã thêm vào giỏ thành công!");
    },
    choose() {
      this.$swal("Bạn phải chọn size để thêm vào giỏ hàng!");
    },
  },

  created() {
    this.axios
      .get("http://127.0.0.1:8000/api/product/" + this.$route.params.url)
      .then((response) => {
        this.product = response.data.product;
        console.log(this.product);
      });
      this.axios
    .get("http://127.0.0.1:8000/api/same/"+this.$route.params.url)
    .then((response)=>{
      this.sameproduct = response.data.data;
    })
  },
};
</script>

<style lang="scss" scoped>
#prodet {
  margin-top: -3%;
  margin-bottom: 3%;
}
</style>
