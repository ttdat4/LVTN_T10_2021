<template>
  <div class="row h-100">
    <div class="col-md-12">
      <h3 class="title">DANH SÁCH NHÀ CUNG CẤP</h3>
    </div>

    <v-data-table
      :headers="headers"
      :items="listSupplier"
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
            label="Tìm kiếm"
            single-line
            hide-details
          ></v-text-field>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                Thêm
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="text-h5">{{ formTitle }}</span>
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12">
                      <v-text-field
                        v-model="editedItem.name"
                        label="Tên nhà cung cấp"
                      ></v-text-field>
                      <v-text-field
                        v-model="editedItem.phonenumber"
                        label="Số điện thoại"
                      ></v-text-field>
                      <v-text-field
                        v-model="editedItem.address"
                        label="Địa chỉ"
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">
                  Hủy
                </v-btn>
                <v-btn color="blue darken-1" text @click="save">
                  Lưu
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class=" text-center text-h5 "
                >Bạn có chắc chắn muốn xóa không?</v-card-title
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete"
                  >Hủy</v-btn
                >
                <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                  >Xóa</v-btn
                >
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">
          mdi-pencil
        </v-icon>
        <v-icon small @click="deleteItem(item)">
          mdi-delete
        </v-icon>
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
      headers: [
        { text: "Mã nhà cung cấp", align: "start", value: "id" },
        { text: "Tên nhà cung cấp", value: "name", sortable: false },
        { text: "Số điện thoại", value: "phonenumber", sortable: false },
        { text: "Địa chỉ", value: "address", sortable: false },
        { text: "Hành động", value: "actions", sortable: false },
      ],
      editedIndex: -1,
      editedItem: {
        name: "",
        phonenumber: "",
        address: "",
      },
      defaultItem: {
        name: "",
        phonenumber: "",
        address: "",
      },
      listSupplier: [], //biến lưu danh sách ncc
    };
  },
  mounted() {
    this.axios
      .get("http://127.0.0.1:8000/api/supplier")
      .then((response) => {
        this.listSupplier = response.data;
      })
      .catch((error) => {
        this.message = error;
      });
  },

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Thêm nhà cung cấp" : "Sửa nhà cung cấp";
    },
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
    renderload() {
      this.axios
        .get("http://127.0.0.1:8000/api/supplier")
        .then((response) => {
          this.listSupplier = response.data;
        })
        .catch((error) => {
          this.message = error;
        });
    },

    editItem(item) {
      this.editedIndex = this.listSupplier.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },
    deleteItem(item) {
      this.deletedIndex = this.listSupplier.indexOf(item);
      this.deletedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },
    deleteItemConfirm() {
      const item = Object.assign(
        this.listSupplier[this.deletedIndex],
        this.deletedItem
      );
      this.axios
        .delete("http://127.0.0.1:8000/api/supplier/" + item.id)
        .then(() => {
          this.$emit("render");
          alert("Xóa nhà cung cấp thành công!");
          this.$router.go();
        })
        .catch(() => {
          console.clear();
          alert("Nhà cung cấp này không thể xóa!");
        });
      this.closeDelete();
    },
    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },
    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },
    save() {
      if (this.editedIndex > -1) {
        const item = Object.assign(
          this.listSupplier[this.editedIndex],
          this.editedItem
        );
        this.axios
          .put("http://127.0.0.1:8000/api/supplier/" + item.id, item)
          .then(() => {
            alert("Sửa thành công");
            this.$router.push("supplier");
          })
          .catch((error) => {
            alert(error);
          });
      } else {
        this.axios
          .post("http://127.0.0.1:8000/api/supplier", this.editedItem)
          .then(() => {
            alert("Thêm thành công!");
            this.renderload();
          })
          .catch((error) => {
            alert(error);
          });
        this.close();
        this.editedItem.name = "";
      }
      this.close();
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
