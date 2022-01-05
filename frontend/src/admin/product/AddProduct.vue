<template>
  <v-form @submit="submit">
    <h3 class="text-center text-success">Thêm sản phẩm</h3>
    <v-container fluid>
      <v-row>
        <v-col cols="12" md="8">
          <v-text-field
            v-model="product.name"
            :rules="rules.name"
            counter
            label="Tên sản phẩm"
            required
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
          <v-text-field
            type="number"
            :rules="rules.price"
            min="2000000"
            v-model="product.price"
            label="Giá"
            required
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col class="d-flex" cols="12" md="3">
          <v-select
            v-model="selectCategory"
            :rules="rules.category"
            :items="categorys"
            clearable
            item-value="id"
            item-text="name"
            label="Danh mục"
          >
          </v-select>
        </v-col>
        <v-col class="d-flex" cols="12" md="3">
          <v-btn color="primary" @click="themCategory">Thêm danh mục</v-btn>
          <strong style="">{{ product.category }}</strong>
        </v-col>
         <v-col class="d-flex" cols="12" md="3">
          <v-select
            v-model="selectSupplier"
            :rules="rules.supplier"
            :items="suppliers"
            clearable
            item-value="id"
            item-text="name"
            label="Nhà cung cấp"
          >
          </v-select>
        </v-col>
        <v-col class="d-flex" cols="12" md="3">
          <v-btn color="primary" @click="themSupplier">Thêm nhà cung cấp</v-btn>
          <strong style="">{{ product.supplier }}</strong>
        </v-col>
      </v-row>
      <v-row>
      <v-col cols="12" md="3">
          <v-text-field
          v-for="(itemSize, indexSize) in product.size" :key="indexSize"
            v-model="itemSize.name"
            :rules="rules.size"
            type="text"
            label="Size"
            required
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="3">
          <v-text-field
           v-for="(itemSize, indexSize) in product.size" :key="indexSize"
            v-model="itemSize.amount"
            :rules="rules.amount"
            type="number"
            min="1"
            label="Số lượng"
            required
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="6">
          <v-textarea
            outlined
            counter
            v-model="product.description"
            :rules="rules.description"
            label="Mô tả sản phẩm"
          ></v-textarea>
        </v-col>
        </v-row>
      <v-row>
        <v-col cols="12" md="8">
          <v-file-input
            v-model="image"
            :rules="rules.image"
            required
            color="deep-purple accent-4"
            counter
            label="Chọn ảnh sản phẩm"
            multiple
            placeholder="Chọn ảnh"
            prepend-icon="mdi-camera"
             @change="imageChange($event)"
            accept="image/jpg, image/jpeg, image/png, image/gif"
            outlined
            show-size
          >
            <template v-slot:selection="{ index, text }">
              <v-chip
                v-if="index < 4"
                color="deep-purple accent-4"
                dark
                label
                small
              >
                {{ text }}
              </v-chip>

              <span
                v-else-if="index === 4"
                class="text-overline grey--text text--darken-3 mx-2"
              >
                +{{ files.length - 4 }} File(s)
              </span>
            </template>
          </v-file-input>
        </v-col>
        <v-col cols="12" md="4">
          <v-btn variant="primary" @click="newSize()" style="width: 100%;"
            >Thêm Size</v-btn
          >
        </v-col>
      </v-row>
      <v-btn color="primary" dark class="mb-2" type="submit">
        Thêm sản phẩm
      </v-btn>
    </v-container>
  </v-form>
</template>

<script>
export default {
  data() {
    return {
      valid: true,
      rules: {
        name: [
          (v) => !!v || "Tên sản phẩm không được để trống",
          (v) => v.length > 6 || "Tên sản phẩm ít nhất 6 kí tự",
        ],
        price: [
          (v) => !!v || "Giá không được để trống",
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
        size: [
          (v) => !!v || "Size không được để trống",
        ],
        amount: [
          (v) => !!v || "Số lượng không được để trống",
        ],
        image: [
          (v) => !!v || "Ảnh không được để trống",
        ],
      },
      product: {
        name: "",
        price: 3000000,
        description: "",
        category: "",
        supplier: "",
        size: [
          {
            name: "",
            amount: 8,
          },
        ],
      },
      image:[], //mảng ảnh đầu vào
      categorys: [],
      suppliers: [],
      selectCategory: {},
      selectSupplier: {},
    };
  },
  methods: {
    themCategory: function() {
      this.product.category = this.selectCategory;
    },
    themSupplier: function() {
      this.product.supplier = this.selectSupplier;
    },
    newSize: function() {
      const sizeNew = {
        name: "",
        amount: 8,
      };
      this.product.size.push(sizeNew);
    },
    imageChange: function(event) {
      const typeImage = ["image/jpeg","image/jpg", "image/png", "image/gif"];     
      for (let index = 0; index < event.target.files.length; index++) {
        if(!typeImage.includes(event.target.files[index].type)){
          this.$router.go();
          alert('Không phải file ảnh');
        }
        else{
          this.image.push(event.target.files[index]);
        }         
      }
    },
    submit: function(e) {
      e.preventDefault();
      this.show = true;

      const formdata = new FormData();
      formdata.append("product", JSON.stringify(this.product));
      for (let index = 0; index < this.image.length; index++) {
        formdata.append("image[]", this.image[index]);
      }
      
      this.axios
        .post("http://127.0.0.1:8000/api/product", formdata)
        .then(() => {
          this.show = false;
          alert("Thêm thành công!");
          this.$router.push("product");
        })
        .catch((error) => {
          this.show = false;
          alert(error.response.data);
          
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
  },
};
</script>

<style lang="scss" scoped></style>
