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
                  Email
                </th>
                <th class="text-center title">
                  Họ và tên
                </th>
                <th class="text-center title ">
                  Địa chỉ
                </th>
                <th class="text-center title ">
                  Số điện thoại
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td id="img" class="img">
                  <v-img
                    max-height="50"
                    max-width="50"
                    src="https://scontent.fsgn8-1.fna.fbcdn.net/v/t1.6435-9/49530449_109623940111355_4250878657842642944_n.jpg?_nc_cat=102&ccb=1-5&_nc_sid=8bfeb9&_nc_ohc=n22nRtCI8eoAX-cbn2_&_nc_ht=scontent.fsgn8-1.fna&oh=00_AT8qGBTbHGA7PnYcqzHxrL1kt3EdoFKpiHVNZ-06K9L4mQ&oe=61F7C926"
                  ></v-img>
                </td>
                <td class="text-center">
                  <h6>{{ users.email }}</h6>
                </td>
                <td class="text-center">
                  <h6>{{ users.name }}</h6>
                </td>
                <td class="text-center">
                  <h6>{{ users.address }}</h6>
                </td>
                <td class="text-center">
                  <h6>0{{ users.phonenumber }}</h6>
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-col>
    </v-row>
    <v-row>
      <v-btn color="error" class="logout" width="250px" @click="logOut"
        >Đăng xuất</v-btn
      ></v-row
    >
  </v-container>
</template>

<script>
export default {
  computed: {
    users() {
      return this.$store.state.user;
    },
  },
  methods: {
    logOut() {
      localStorage.removeItem("token");
      localStorage.removeItem("user");
      localStorage.removeItem("role");
      this.$store.state.user = "";
      this.$store.state.role = "";
      this.$router.push("/");
    },
  },
};
</script>

<style lang="scss" scoped>
#img {
  padding-left: 110px;
}
.logout {
  margin-left: 75%;
}
</style>
