<template>
  <v-app-bar app dark padless>
    <v-avatar
      :color="$vuetify.breakpoint.smAndDown ? 'grey darken-1' : 'transparent'"
      size="32"
    ></v-avatar>

    <v-tabs centered class="ml-n9" color="grey darken-1">
      <v-tab to="/">
        TRANG CHỦ
      </v-tab>
      <v-tab to="/product">
        SẢN PHẨM
      </v-tab>

      <v-tab to="/contact">
        LIÊN HỆ
      </v-tab>
      <v-tab to="/cart">
        GIỎ HÀNG
      </v-tab>
    </v-tabs>
    <v-avatar>
      <img
        src="http://127.0.0.1:8000/image/product/vong-tay-dep171.jpg"
      />
    </v-avatar>

    <div class="ml-2">
      <v-btn to="/login" dark v-if="user == '' || user == null">
        Tài khoản
      </v-btn>
      <v-btn v-else @click="logOut" dark>
        {{ user }}
      </v-btn>
    </div>
  </v-app-bar>
</template>

<script>
export default {
  computed: {
    user() {
      return this.$store.state.name;
    },
  },
  methods: {
    logOut: function() {
      localStorage.removeItem("token");
      this.$store.state.name = "";
    },
  },
};
</script>

<style lang="scss" scoped></style>
