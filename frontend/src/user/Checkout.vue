<template>
  <v-container fluid>
    <v-row>
      <v-col cols="12" md="5">
        <v-form class="elevation-5 formProduct">
          <strong>THÔNG TIN SẢN PHẨM</strong>
          <v-row v-for="(item, index) in cart" :key="index">
            <v-col cols="12" md="5">
              <v-img
                max-height="150px"
                max-width="150px"
                :src="item.img"
              ></v-img>
            </v-col>
            <v-col cols="12" md="6">
              <v-row>
                <v-col cols="12" sm="12"
                  ><p class="font-italic">
                    Tên sản phẩm: {{ item.name }} / {{ item.sizeName }}
                  </p></v-col
                >
                <v-col cols="12" sm="12"
                  ><span class="font-italic">
                    Giá: {{ item.price.toLocaleString() }} đ
                  </span>
                  <span class="font-italic ml-3">
                    Số lượng: {{ item.quanlity }}
                  </span>
                </v-col>
              </v-row>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" class="temp"
              >Tạm tính <input type="number" readonly :value="total" /><span
                >đ</span
              ></v-col
            >
            <v-col cols="12"
              >Chi phí vận chuyển
              <input class="transport" type="text" readonly value="Miễn phí"
            /></v-col>
            <v-divider></v-divider>
            <v-col cols="12" class="temp"
              >Thành tiền <input type="number" readonly :value="total" /><span
                >đ</span
              ></v-col
            >
          </v-row>
        </v-form>
      </v-col>
      <v-col cols="12" md="7">
        <v-form v-model="valid" class="elevation-5 formUser" @submit="submit">
          <strong>THÔNG TIN KHÁCH HÀNG</strong>
          <v-row>
            <v-col cols="6"
              ><v-text-field
                v-model="invoice.name"
                :rules="rules.name"
                label="Họ tên"
                required
              ></v-text-field
            ></v-col>
            <v-col cols="6"
              ><v-text-field
                v-model="invoice.phonenumber"
                :rules="rules.phonenumber"
                label="Số điện thoại"
                required
              ></v-text-field
            ></v-col>
            <v-col cols="6"
              ><v-text-field
                v-model="invoice.email"
                :rules="rules.email"
                label="Email"
                required
              ></v-text-field
            ></v-col>
            <v-col cols="6"
              ><v-text-field
                v-model="invoice.address"
                :rules="rules.address"
                label="Địa chỉ"
                required
              ></v-text-field
            ></v-col>
          </v-row>
          <v-row>
            <strong>HÌNH THỨC NHẬN HÀNG</strong>
            <v-radio-group v-model="invoice.method_delivery">
              <v-radio
                label="Giao hàng tận nơi (Thanh toán khi nhận hàng)"
                value="Deliver"
              ></v-radio>
              <v-radio label="Giữ hàng khách đến nhận" value="Hold"></v-radio>
            </v-radio-group>
            <v-col cols="12">
              <v-text-field
                v-model="invoice.note"
                label="Ghi chú khác"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row class="mt-8">
            <v-col cols="12" class="d-flex justify-center">
              <v-btn color="primary" to="product">Tiếp tục mua hàng</v-btn>
              <v-btn
                :disabled="!valid"
                color="success"
                class="ml-3"
                type="submit"
                @click="validate"
                >Đặt hàng</v-btn
              >
            </v-col>
          </v-row>
        </v-form>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "Checkout",
  computed: {
    cart() {
      return this.$store.state.cart;
    },
    total() {
      return this.$store.getters.total;
    },
    user() {
      return this.$store.state.user;
    },
  },
  data() {
    return {
      valid: true,

      product: [],
      invoice: {
        name: "",
        address: "",
        email: "",
        phonenumber: "",
        total: this.$store.getters.total,
        user_id: "",
        method_delivery: "Deliver",
        invoiceDetails: [],
        note: "",
      },

      rules: {
        name: [
          (v) => !!v || "Tên người dùng không được để trống",
          (v) => v.length > 6 || "Tên người dùng ít nhất 6 kí tự",
        ],
        phonenumber: [
          (v) => !!v || "Số điện thoại không được để trống",
          (v) =>
            (v.length <= 10) & (v.length >= 10) ||
            "Số điện thoại bằng 10 kí tự số",
        ],
        email: [
          (v) => !!v || "E-mail không được để trống",
          (v) => /.+@.+/.test(v) || "E-mail phải hợp lệ",
        ],
        address: [
          (v) => !!v || "Địa chỉ không được để trống",
          (v) => v.length > 20 || "Địa chỉ ít nhất 20 kí tự",
        ],
      },
    };
  },
 
  methods: {
    validate() {
      this.$refs.form.validate();
    },
    submit: function(e) {
      e.preventDefault();
      this.show = true;
      const temp = [];
      this.cart.forEach((el) => {
        const item = {
          size: el.sizeName,
          amount: el.quanlity,
          product_id: el.id,
        };
        temp.push(item);
      });
      this.invoice.user_id = this.user.id;
      this.invoice.invoiceDetails = temp;
      const formdata = new FormData();
      formdata.append("invoice", JSON.stringify(this.invoice));
      this.axios
        .post("http://127.0.0.1:8000/api/invoice", formdata)
        .then(() => {
          this.show = false;
          this.$router.push("/");
          alert("Đặt hàng thành công!");
          this.$store.dispatch("removeCartBeforeCheckout");

        })
        .catch((error) => {
          this.show = false;
          alert(error.response.data);
        });
    },
  },

  created() {
    if (this.user == null) {
      this.$router.push("/");
    }
  },
};
</script>

<style scoped>
.transport {
  width: 100px;
  margin-left: 105px;
  font-weight: bold;
}
.temp input {
  width: 105px;
  margin-left: 35%;
}
.temp span {
  margin-left: -18px;
}
.temp:last-child input {
  margin-left: 32%;
  font-weight: bold;
  color: red;
}
.formProduct {
  padding: 20px;
}
.formUser {
  padding: 20px;
}
</style>
