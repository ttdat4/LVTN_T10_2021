<template>
  <div>
    <h3 class="text-center">DANH SÁCH ĐƠN HÀNG</h3>

    <v-dialog v-model="dialog" max-width="900px">
      <v-card>
        <v-card-title
          >Chi tiết hóa đơn
          <v-spacer></v-spacer>

          <v-btn color="blue darken-1" text @click="close"> </v-btn
        ></v-card-title>
        <v-container>
          <v-row>
            <v-col>
              <span>Mã đơn hàng: {{ editedItem.id }}</span></v-col
            >
            <v-col
              ><span>Người đặt đơn hàng: {{ editedItem.name }}</span></v-col
            >
            <v-col
              ><span>Số điện thoại: {{ editedItem.phonenumber }}</span></v-col
            >
          </v-row>
          <v-row>
            <v-col
              ><span>Địa chỉ: {{ editedItem.address }}</span></v-col
            ></v-row
          >
          <v-row>
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
          </v-row>
          <v-row>
            <v-col>
              <span>Tổng tiền đơn hàng: {{ editedItem.total }} vnđ</span>
            </v-col>
            <v-col v-if="editedItem.status == 0">
              <span> Tình trạng đơn hàng: Chưa xử lý</span>
            </v-col>
            <v-col v-else-if="editedItem.status == 1">
              <span> Tình trạng đơn hàng: Đã xác nhận</span>
            </v-col>
            <v-col v-else-if="editedItem.status == 2">
              <span> Tình trạng đơn hàng: Đang giao hàng</span>
            </v-col>
            <v-col v-else-if="editedItem.status == 3">
              <span> Tình trạng đơn hàng: Đã nhận hàng</span>
            </v-col>
            <v-col v-else-if="editedItem.status == 4">
              <span> Tình trạng đơn hàng: Đơn bị hủy</span>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <span>Chi tiết đơn hàng</span>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-simple-table>
                <template #default>
                  <thead>
                    <tr>
                      <th class="text-center"><h6>Tên sản phẩm</h6></th>
                      <th class="text-center"><h6>Giá tiền</h6></th>
                      <th class="text-center"><h6>Số lượng</h6></th>
                      <th class="text-center"><h6>Thành tiền</h6></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(item, index) in editedItem.invoicedetails"
                      :key="index"
                    >
                      <td class="text-center">{{ item.name }}</td>
                      <td class="text-center">{{ item.price }}</td>
                      <td class="text-center">{{ item.amount }}</td>
                      <td class="text-center">
                        {{ item.price * item.amount }}
                      </td>
                    </tr>
                  </tbody>
                </template></v-simple-table
              ></v-col
            >
          </v-row>
        </v-container>
      </v-card>
    </v-dialog>
    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-center">
              Mã đơn hàng
            </th>
            <th class="text-center">
              Tên khách hàng
            </th>
            <th class="text-center">
              Địa chỉ
            </th>
            <th class="text-center">
              Số điện thoại
            </th>
            <th class="text-center">
              Sản phẩm
            </th>
            <th id="selectStatus" class="text-center" >
              Hành động
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in listInvoice" :key="item.name">
            <td class="text-center">{{ item.id }}</td>
            <td class="text-center">{{ item.name }}</td>
            <td class="text-center">{{ item.address }}</td>
            <td class="text-center">{{ item.phonenumber }}</td>
            <td class="text-center">
              {{ item.invoicedetails.length }}
              <v-icon small @click="detail(item)">
                mdi-eye
              </v-icon>
            </td>
            <td>
              <v-row>
                <v-col cols="12" md="4">
                  <v-btn
                    v-if="statusInvoice == 0"
                    color="primary"
                    dark
                    class="mb-2"
                    v-bind="attrs"
                    v-on="on"
                    @click="editItem(1)"
                  >
                    Xác nhận
                  </v-btn>
                  <v-btn
                    v-if="statusInvoice == 1"
                    color="primary"
                    dark
                    class="mb-2"
                    v-bind="attrs"
                    v-on="on"
                     @click="editItem(2)"
                  >
                    Giao hàng
                  </v-btn>
                  
                  <v-btn
                    v-if="statusInvoice == 2"
                    color="primary"
                    dark
                    class="mb-2"
                    v-bind="attrs"
                    v-on="on"
                     @click="editItem(3)"
                  >
                    Đã nhận
                  </v-btn>
                </v-col>
                <v-col cols="12" md="5">
                  <v-btn
                    v-if="statusInvoice == 1"
                    color="red"
                    dark
                    class="mb-2 ml-14"
                    v-bind="attrs"
                    v-on="on"
                     @click="editItem(4)"
                  >
                    Hủy
                  </v-btn>
                  <v-btn
                    v-if="statusInvoice == 0"
                    color="red"
                    dark
                    class="mb-2 ml-14"
                    v-bind="attrs"
                    v-on="on"
                     @click="editItem(4)"
                  >
                    Hủy
                  </v-btn>
                </v-col>
              </v-row>
              <v-dialog v-model="dialogStatus" max-width="450px">
                <v-col cols="12">
                  <h6>
                    Bạn có chắc chắn muốn thay đổi trạng thái hóa đơn không?
                  </h6>
                </v-col>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="blue darken-1"
                    text
                    @click="dialogStatus = false"
                  >
                    Đóng
                  </v-btn>
                  <v-btn color="blue darken-1" text @click="save(item.id)">
                    Lưu
                  </v-btn>
                </v-card-actions>
              </v-dialog>
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
      dialog: false,
      dialogStatus: false,
      search: "",
      editedIndex: -1,
      itemStatus: [
        { name: "Chưa xử lý", key: 0 },
        { name: "Đã xác nhận", key: 1 },
        { name: "Đang giao", key: 2 },
        { name: "Đã nhận hàng", key: 3 },
        { name: "Đơn bị hủy", key: 4 },
      ],
      editedItem: {},
      statusChange: "",
    };
  },
  computed: {
    listInvoice() {
      return this.$store.state.filteredList;
    },
    user() {
      return this.$store.state.user;
    },
    statusInvoice() {
      return this.listInvoice[0].status;
    },
  },

  methods: {
    activeMenu() {
      this.isActive = !this.isActive;
    },
    changeStatusInvoice() {
      this.$store.dispatch("filteredList", this.filteredList);
      this.$router.push("/admin/invoice");
    },
    editItem(data) {
      this.dialogStatus = true;
      this.statusChange= data;
    },
    getDate(datetime) {
      let date = new Date(datetime)
        .toJSON()
        .slice(0, 10)
        .replace(/-/g, "/");
      return date;
    },
    detail(item) {
      this.dialog = true;
      this.editedItem = Object.assign({}, item);
    },
    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
      });
    },
    save(id) {
      const invoice = {
        status: this.statusChange,
        user_id: this.user.id,
      };

      this.axios
        .put("http://127.0.0.1:8000/api/invoice/" + id, invoice)
        .then(() => {
          this.axios
            .get("http://127.0.0.1:8000/api/invoice")
            .then((response) => {
              this.$store.dispatch("getInvoice", response.data.invoice);
            });

          this.$router.push("/admin");
        });

      this.close();
    },
  },
};
</script>
<style scoped>
#selectStatus {
  width: 200px;
}
</style>
