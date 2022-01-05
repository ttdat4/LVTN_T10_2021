<template>
  <v-container fluid>
    <h3 class="text-center text-success">Sửa sản phẩm</h3>
    
    <v-row>
      <v-col cols="12" md="6">
        <v-text-field
          v-model="product.name"
          :rules="rules.name"
          counter
          label="Tên sản phẩm"
          required
        ></v-text-field>
      </v-col>

      <v-col cols="12" md="3">
        <v-text-field
          v-model="product.price"
          :rules="rules.price"
          label="Giá"
          type="number"
          required
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="3">
        <v-text-field
          v-model="product.status"
          :rules="rules.status"
          label="Trạng thái"
          type="number"
          required
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row>
      <v-col class="d-flex" cols="12" md="8">
        <v-select
        
          v-model="selectCategory"
          :items="categorys"
          :rules="rules.category"
          clearable
          item-value="id"
          item-text="name"
          label="Danh mục"
        >
        </v-select>
      </v-col>
      <v-col class="d-flex" cols="12" md="4">
        <v-btn color="primary" @click="themCategory">Thêm danh mục</v-btn>
        <strong style="">{{ product.category_id }}</strong>
      </v-col>
    </v-row>
    <v-row>
      <v-col class="d-flex" cols="12" md="8">
        <v-select
          v-model="selectSupplier"
          :items="suppliers"
          :rules="rules.supplier"
          clearable
          item-value="id"
          item-text="name"
          label="Nhà cung cấp"
        >
        </v-select>
      </v-col>

     <v-col class="d-flex" cols="12" md="4">
          <v-btn color="primary" @click="themSupplier">Thêm nhà cung cấp</v-btn>
          <strong style="">{{ product.supplier_id }}</strong>
        </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" md="8">
        <v-textarea
          v-model="product.description"
          :rules="rules.description"
          counter
          outlined
          name="input-7-4"
          label="Mô tả sản phẩm"
          value=""
        ></v-textarea>
      </v-col>
    </v-row>
    <v-btn
      color="success"
      dark
      class="mb-2"
      @click="update"
    >
      Sửa sản phẩm
    </v-btn>
  </v-container>

</template>

<script>
export default {
  name: "UpdateProduct",
  data() {
    return {
      rules: {
        name: [
          (v) => !!v || "Tên sản phẩm không được để trống",
          (v) => v.length > 6 || "Tên sản phẩm ít nhất 6 kí tự",
        ],
        price: [
          (v) => !!v || "Giá không được để trống",
        ],
        status: [
          (v) => !!v || "Trạng thái không được để trống",
        ],
        category: [
          (v) => !!v || "Danh mục không được để trống",
        ],
        supplier: [
          (v) => !!v || "Nhà cung cấp không được để trống",
        ],
        description: [
          (v) => !!v || "Mô tả không được để trống",
        ],
      },
      product: {
        name: "",
        price: 0,
        status: "",
        description: "",
        category_id: "",
        supplier_id: "",
      },
      categorys: [],
      selectCategory: {
        name:"",
      },
      suppliers: [],
      selectSupplier: {
        name:"",
      },
    };
  },
  created(){
     this.axios
        .get("http://127.0.0.1:8000/api/product/"+this.$route.params.url)
        .then((response) => {
          this.product = response.data.product;
          this.selectCategory = response.data.product[0].category;
          console.log(this.selectCategory);
        });
  },
  methods: {
    themCategory: function() {
      this.product.category_id = this.selectCategory;
    },
    themSupplier: function() {
      this.product.supplier_id = this.selectSupplier;
    },
    update(){
      const product = {
        name: this.product.name,
        price: this.product.price,
        status: this.product.status,
        description: this.product.description,
        category_id: this.product.category_id,
        supplier_id: this.product.supplier_id,
      };
      console.log(product);
       this.axios
        .put("http://127.0.0.1:8000/api/product/" + this.$route.params.url, product)
        .then(() => {
          alert("Sửa thành công");
          this.$router.push("/admin/product");
        })
        .catch((error) => {
          console.log(error.response.product);
        });

       

    },
    
  },
  mounted() {
    this.axios
      .get("http://127.0.0.1:8000/api/category")
      .then((response) => {
        this.categorys = response.data;
      })
      .catch((error) => {
        alert(error);
      });
    this.axios
      .get("http://127.0.0.1:8000/api/supplier")
      .then((response) => {
        this.suppliers = response.data;
      })
      .catch((error) => {
        alert(error);
      });
    this.axios
      .get("http://127.0.0.1:8000/api/product/" + id)
      .then((response) => {
        this.product = response.data.product;
      })
      .catch((error) => {
        alert(error.response);
      });
  },
};
</script>

<style lang="scss" scoped></style>
