<template>
  <div class="row h-100">
    <div class="col-md-12">
      <h3 class="title">DANH SÁCH SẢN PHẨM</h3>
    </div>
    <v-dialog v-model="dialog" max-width="900px">
      <v-card>
        <v-card-title
          >Chi tiết sản phẩm
          <v-spacer></v-spacer>

          <v-btn color="blue darken-1" text @click="close"> </v-btn
        ></v-card-title>
        <v-container>
          <v-row>
            <v-col>
              <span>Mã sản phẩm: {{ editedItem.id }}</span></v-col
            >
            <v-col
              ><span>Tên sản phẩm: {{ editedItem.name }}</span></v-col
            >
            <v-col
              ><span>Giá: {{ editedItem.price }}</span></v-col
            >
          </v-row>
          <v-row>
            <v-col
              ><span>Mô tả sản phẩm: {{ editedItem.description }}</span>
            </v-col>
          </v-row>
          <v-row>
            <v-col v-if="editedItem.status == 0">
              <span> Tình trạng sản phẩm: Tạm hết hàng</span>
            </v-col>
            <v-col v-else-if="editedItem.status == 1">
              <span> Tình trạng sản phẩm: Đang kinh doanh</span>
            </v-col>
            <v-col v-else-if="editedItem.status == 2">
              <span> Tình trạng sản phẩm: BestSeller</span>
            </v-col>
            <v-col v-else-if="editedItem.status == 3">
              <span> Tình trạng sản phẩm: Sắp về hàng</span>
            </v-col>
            <v-col v-else-if="editedItem.status == 4">
              <span> Tình trạng sản phẩm: Hàng khuyến mãi</span>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-simple-table>
                <template #default>
                  <thead>
                    <tr>
                      <th class="text-left"><h6>Hình ảnh</h6></th>
                      <th class="text-center"><h6>Size</h6></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <v-img
                          max-height="100"
                          max-width="100"
                          :src="editedItem.image[0].urlimg"
                        ></v-img>
                      </td>
                      <td
                        v-for="(itemSize, indexSize) in editedItem.size"
                        :key="indexSize"
                      >
                        <p>{{ itemSize.name }}</p>
                        <p>{{ itemSize.amount }}</p>
                      </td>
                    </tr>
                  </tbody>
                </template></v-simple-table
              ></v-col
            >
          </v-row>
          <!-- <v-row>
            <v-col>Email: {{ editedItem.email }}</v-col>
            <v-col>Thời gian đặt đơn hàng: {{ editedItem.created_at }}</v-col>
          </v-row>
          <v-row>
            <v-col v-if="editedItem.method_delivery == 'Hold'">
              <span> Phương thức giao hàng: Giữ hàng</span>
            </v-col>
            <v-col v-else>
              <span> Phương thức giao hàng: Giao hàng</span>
            </v-col>
            <v-col>
              <span>Ghi chú: {{ editedItem.note }}</span>
            </v-col>
          </v-row> -->
        </v-container>
      </v-card>
    </v-dialog>
    <v-data-table
      :headers="headers"
      :items="listProduct"
      :search="search"
      sort-by="id"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
          <v-spacer></v-spacer>
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
        </v-toolbar>
      </template>
      <v-dialog v-model="dialogDelete" max-width="500px">
        <v-card>
          <v-card-title class=" text-center text-h5 "
            >Bạn có chắc chắn muốn xóa không?</v-card-title
          >
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="closeDelete">Hủy</v-btn>
            <v-btn color="blue darken-1" text @click="deleteItemConfirm"
              >Xóa</v-btn
            >
            <v-spacer></v-spacer>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="update(item.id)">
          mdi-pencil
        </v-icon>
        
        <v-icon small @click="detail(item)"> mdi-eye </v-icon>
      </template>
    </v-data-table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      search: "",
      dialog: false,
      dialogDelete: false,
      editedIndex: -1,
      editedItem: {},
      defaultItem: {
        name: "",
      },
      headers: [
        { text: "Mã sản phẩm", align: "start", value: "id" },
        { text: "Tên sản phẩm", value: "name", sortable: false },
        { text: "Giá", value: "price", sortable: false },
        { text: "Tên loại sản phẩm", value: "category.name", sortable: false },
        { text: "Tên nhà cung cấp", value: "supplier.name", sortable: false },
        { text: "Hành động", value: "actions", sortable: false },
      ],
      listProduct: [], //biến lưu danh sách SP
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

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },
  methods: {

    editItem() {
      this.$router.push("/");
    },
    update(id){
      this.$router.push("/admin/update-product/"+id);
    },
    detail(item) {
      this.dialog = true;
      this.editedItem = Object.assign({}, item);
      console.log(this.editedItem.image[0].urlimg);
    },
    deleteItem(item) {
      this.deletedIndex = this.listProduct.indexOf(item);
      this.deletedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },
    deleteItemConfirm() {
      const item = Object.assign(
        this.listProduct[this.deletedIndex],
        this.deletedItem
      );

      // this.axios
      //   .delete("http://127.0.0.1:8000/api/category/" + item.id)
      //   .then(() => {
      //     this.$emit("render");
      //     alert("Xóa thành công!!");
      //     this.$router.go();
      //   })
      //   .catch(() => {
      //     console.clear();
      //     alert("Danh mục này không thể xóa!!");
      //   });
      this.closeDelete();
    },
    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },
   
  },
};
</script>

<style lang="scss" scoped>
.form-group {
  input {
    font-size: 18px;
    padding: 10px 10px 10px 10px;
    display: block;
    width: 100%;
    border: none;
    border-bottom: 2px solid rgba(0, 0, 0, 0.3);
    background: none;
  }
}
.title {
  text-align: center;
  font-family: Arial, Helvetica, sans-serif;
  font-weight: bold;
}
.addcategory {
  background-color: green;
  margin: 10px;
}
</style>
