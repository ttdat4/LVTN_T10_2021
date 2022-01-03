<template>
  <v-container fluid>
    <v-row>
      <v-col>
        <v-simple-table>
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-center title">
                  Hình ảnh
                </th>
                <th class="text-center title">
                  Tên sản phẩm
                </th>
                <th class="text-center title ">
                  Giá
                </th>
                <th class="text-center title ">
                  Số lượng
                </th>
                <th class="text-center title">
                  Hành động
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in cart" :key="index">
                <td class="img">
                  <v-img
                    max-height="250"
                    max-width="250"
                    :src="item.img"
                  ></v-img>
                </td>
                <td class="text-center">
                  <router-link
                    :to="{
                      name: 'ProductDetails',
                      params: { url: item.id },
                    }"
                    style="text-decoration:none"
                  >
                    <h6>{{ item.name }} / {{ item.sizeName }}</h6>
                  </router-link>
                </td>
                <td class="text-center">
                  <h6>{{ item.price.toLocaleString() }} vnđ</h6>
                </td>
                <td class="text-center">
                  <v-icon
                    slot="prepend"
                    color="green"
                    class="minus"
                    @click="minus(index)"
                  >
                    mdi-minus
                  </v-icon>

                  <input
                    class="count"
                    type="number"
                    min="1"
                    readonly
                    :value="item.quanlity"
                  />

                  <v-icon
                    slot="append"
                    color="red"
                    class="plus"
                    @click="plus(index)"
                  >
                    mdi-plus
                  </v-icon>
                </td>
                <td class="text-center" @click="removeProductCart(index)">
                  <v-btn color="error" dark>
                    <v-icon>delete</v-icon>
                  </v-btn>
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-col>
    </v-row>
    <v-row class="total mt-10">
      <v-col>
        <v-row>
          <h3 id="total">
            Tổng tiền:
            <input class="totalbill" type="number" readonly :value="total" />vnđ
          </h3>
        </v-row>

        <v-row>
          <v-btn
            color="success"
            class="checkout"
            width="250px"
            @click="checkout"
            >Thanh toán</v-btn
          ></v-row
        >
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "Cart",
  data: () => ({
    valid: true,
  }),
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
  methods: {
    validate() {
      this.$refs.form.validate();
    },
    removeProductCart(indexRemove) {
      this.$store.dispatch("removeProductCart", indexRemove);
    },
    plus(index) {
      this.$store.dispatch("plus", index);
    },
    minus(index) {
      this.$store.dispatch("minus", index);
    },
    checkout() {
      if (this.user != null) {
        this.$router.push("checkout");
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.img {
  width: 300px;
}
.total {
  float: right;
  margin-right: 10%;
  h3 input {
    color: red;
  }

  margin-bottom: 40px;
}
.discount {
  float: left;
  margin-left: 50px;
}
.count {
  text-align: center;
  font-size: 20px;
  width: 60px;
}
.minus {
  font-size: 17px;
  margin-right: 10px;
  cursor: pointer;
}
.plus {
  font-size: 17px;
  margin-left: -7px;
  cursor: pointer;
}
.totalbill {
  width: 180px;
  margin-left: 5px;
}
.checkout {
  margin-left: 20%;
}
</style>
