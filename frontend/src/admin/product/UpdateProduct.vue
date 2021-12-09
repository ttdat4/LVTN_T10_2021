<template>
  
  <v-container>
      <h3 class="text-center text-success">Sửa sản phẩm</h3>
      <v-row>
        <v-col cols="12" md="8">
          <v-text-field
            v-model="firstname"
            :rules="nameRules"
            :counter="10"
            label="Tên sản phẩm"
            required
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
          <v-text-field
            v-model="price"
            :rules="emailRules"
            label="Giá"
            required
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col class="d-flex" cols="12" md="8">
         
          <v-select
            v-model="categoryId"
            :items="categorys"
            clearable
            item-value="id"
            item-text="name"
            label="Danh mục"
          >
          </v-select>
         
        </v-col>

        <v-col cols="12" md="4">
           
        </v-col>
      </v-row>
      
      <v-row>
        <v-col cols="12" md="8">
          <v-textarea
            outlined
            name="input-7-4"
            label="Mô tả sản phẩm"
            value=""
          ></v-textarea>
        </v-col>
      </v-row>
       <v-btn
      color="primary"
      dark
      class="mb-2"
      v-bind="attrs"
      v-on="on"
      to="add-product"
    >
      Sửa sản phẩm
    </v-btn>
  </v-container>
      <!-- <h3 class="text-center text-primary">Sửa sản phẩm</h3>
      <v-form @submit="submit">
        <v-container fluid>
          <v-row>
            <v-col>
              <v-row>
                <v-col sm="12">
                  <v-text-field
                    v-model="firstname"
                    :rules="nameRules"
                    :counter="10"
                    label="Tên sản phẩm"
                    required
                  ></v-text-field>
                </v-col>
              </v-row>

              <!-Danh mục -->
              <!-- <v-row>
                <v-col sm="12">
                  <v-form-group id="name" label="Danh mục :" label-for="name">
                    <v-form-select
                      v-model="selectCategory"
                      size="sm"
                      class="mt-3"
                      required
                    >
                      <v-form-select-option
                        v-for="(itemCategory, index) in categorys"
                        :key="index"
                        :value="itemCategory"
                      >
                      </v-form-select-option>
                    </v-form-select>
                  </v-form-group>

                  <v-button variant="primary" @click="themCategory"
                    >Thêm danh mục</v-button
                  >
                  <div>
                    Danh mục được chọn:
                    <strong>{{ product.category.name || "" }}</strong>
                  </div>
                </v-col>
              </v-row>

              <v-row>
                <v-col sm="6">
                  <v-form-group id="price" label="Đơn giá:" label-for="price">
                    <v-form-input
                      id="price"
                      v-model="product.price"
                      type="number"
                      name="price"
                      placeholder="Nhập giá sản phẩm"
                      required
                      min="100000"
                      max="2000000"
                    ></v-form-input>
                  </v-form-group>
                </v-col>
              </v-row>

              <v-row>
                <v-col>
                  <v-form-textarea
                    id="description"
                    v-model="product.description"
                    type="text"
                    placeholder="Mô tả"
                    required
                    rows="3"
                    max-rows="6"
                  ></v-form-textarea>
                </v-col>
              </v-row>
              <v-row> -->
                <!-- BUTTOM THÊM SẢN PHẨM -->
                <!-- <v-button
                  id="btnThem"
                  type="submit"
                  variant="primary"
                  style="margin-left: 10px; width: 12%;"
                  >Sửa sản phẩm</v-button
                ></v-row
              >
            </v-col>
          </v-row>
        </v-container>
      </v-form> -->

  
</template>

<script>
export default {
  name: "UpdateProduct",
  data() {
    return {
      product: {
        name: "",
        price: 0,
        description: "",
        category: {
          name: "",
        },
      },
      categorys: [],
      selectCategory: {},
     
    };
  },
  methods: {
    submit: function(e) {
      e.preventDefault();
      const put = {
        product: this.product,
      };
      this.axios
        .put("http://127.0.0.1:8000/api/product/" + this.$route.params.url, put)
        .then(() => {
          this.show = !this.show;
          alert("Sửa thành công");
          this.$router.push("product");
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },
    themCategory: function() {
      this.product.category = this.selectCategory;
      this.product.category_id = this.selectCategory.id;
    },
  },
  mounted() {
    this.axios
      .get("http://127.0.0.1:8000/api/category")
      .then((response) => {
        this.categorys = response.data;
      })
      .catch((error) => {
        alert(error.response);
      });
    this.axios
      .get("http://127.0.0.1:8000/api/product/" + this.$route.params.url)
      .then((response) => {
        this.product = response.data.data;
        this.selectCategory = response.data.data.category;
         console.log(response.data.data.category);
      })
      .catch((error) => {
        alert(error.response);
      });
  },
};
</script>

<style lang="scss" scoped></style>
