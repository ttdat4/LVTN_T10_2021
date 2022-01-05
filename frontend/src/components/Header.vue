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
      <v-tab to="/contact">
        LIÊN HỆ
      </v-tab>
      <v-tab to="/cart">
        <v-badge v-if="cart.length > 0" color="pink darken-1" :content="cart.length">
          GIỎ HÀNG
        </v-badge>
        <v-badge v-else color="pink darken-1" content="0">
          GIỎ HÀNG
        </v-badge>
      </v-tab>
    </v-tabs>
    <v-avatar>
      <img src="https://cdn.vuetifyjs.com/images/john.jpg" />
    </v-avatar>

    <div class="ml-2">
      <v-btn to="/login" dark v-if="user == '' || user == null">
        Tài khoản
      </v-btn>
      <v-btn v-else @click="profile" dark>
        {{ user.name }}
      </v-btn>
    </div>
  </v-app-bar>
</template>

<script>
export default {
  computed: {
    cart() {
      return this.$store.state.cart;
    },
    user() {
      return this.$store.state.user;
    },
  },
  methods: {
    logOut: function() {
      localStorage.removeItem("token");
      localStorage.removeItem("user");
      localStorage.removeItem("role");
      this.$store.state.user = "";
      this.$store.state.role = "";
    },
    profile() {
      this.$router.push("/profile");
    },
  },
};
</script>

<style lang="scss" scoped></style>
