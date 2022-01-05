<template>
  <div>
    <h3 class="text-center">DANH SÁCH SẢN PHẨM</h3>
    <v-btn
      color="primary"
      dark
      class="mb-2"
      v-bind="attrs"
      v-on="on"
      to="add-product"
    >
      Thêm
    </v-btn>

    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left ">
              Mã sản phẩm
            </th>
            <th class="text-left">
              Tên sản phẩm
            </th>
            <th class="text-left">
              Giá
            </th>
            <th class="text-left">
              Tên loại sản phẩm
            </th>
            <th class="text-left">
              Tên nhà cung cấp
            </th>
            <th class="text-left">
              Hình ảnh
            </th>
            <th class="text-center" colspan="2">
              Size
            </th>
            <th class="text-left">
              Hành động
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in listProduct" :key="item.name">
            <td>{{ item.id }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.price.toLocaleString() }} vnđ</td>
            <td>{{ item.category.name }}</td>
            <td>{{ item.supplier.name }}</td>
            <td>
              <v-img
                max-height="100"
                max-width="100"
                :src="item.image[0].urlimg"
              ></v-img>
            </td>
            <td v-for="(itemSize, indexSize) in item.size" :key="indexSize">
              <p>{{ itemSize.name }}</p>
              <p>{{ itemSize.amount }}</p>
            </td>

            <td>
              <!-- <v-icon small class="mr-2" @click="editItem(item)">
                mdi-pencil
              </v-icon> -->

              <v-btn
                color="primary"
                dark
                class="mb-2"
                v-bind="attrs"
                v-on="on"
                @click="update(item.id)"
              >
                Sửa
              </v-btn>

              <v-icon small @click="deleteItem(item)">
                mdi-delete
              </v-icon>
            </td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      search: "",
      listProduct: [],
      editedIndex: -1,
      editedItem: {},
      updateProduct: {},
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
  methods: {
    update(id) {
      this.$router.push("/admin/update-product/" + id);
    },
    editItem(item) {
      this.editedIndex = this.listProduct.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },
  },
};
</script>
