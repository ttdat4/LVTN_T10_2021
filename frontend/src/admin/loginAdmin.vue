<template>
  <div class="login">
    <v-container fluid>
      <v-row align="center" justify="center">
        <v-col cols="12">
          <v-card class="elevation-1 mt-10">
            <v-window v-model="step">
              <v-window-item :value="1">
                <v-row>
                  <v-col cols="12" md="6">
                    <v-alert v-show="message != ''" type="error">{{
                      message
                    }}</v-alert>
                    <v-card-text class="mt-12">
                      <h4 class="text-center">
                        ĐĂNG NHẬP
                      </h4>
                      <h6 class="text-center  grey--text ">
                        Vui lòng đăng nhập tài khoản của bạn.
                      </h6>
                      <v-form @submit="onLogin" v-if="show" class="login">
                        <v-row align="center" justify="center">
                          <v-col cols="12" sm="10">
                            <v-text-field
                              v-model="login.email"
                              :rules="role.emailRules"
                              label="Email"
                              outlined
                              dense
                              color="blue"
                              autocomplete="false"
                              class="mt-16"
                              required
                            />
                            <v-text-field
                              v-model="login.password"
                              :rules="role.passwordRules"
                              label="Mật khẩu"
                              counter=""
                              outlined
                              dense
                              color="blue"
                              autocomplete="false"
                              :type="showPassword ? 'text' : 'password'"
                              :append-icon="
                                showPassword ? 'mdi-eye' : 'mdi-eye-off'
                              "
                              @click:append="showPassword = !showPassword"
                            />
                            <v-btn color="blue" dark block tile type="submit"
                              >ĐĂNG NHẬP
                              <div
                                class="spinner-border text-success"
                                role="status"
                                v-show="isActive"
                              >
                                <span class="sr-only">Loading...</span>
                              </div></v-btn
                            >
                          </v-col>
                        </v-row>
                      </v-form>
                    </v-card-text>
                  </v-col>

                 
                </v-row>
              </v-window-item>
            </v-window>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
export default {
    name: "loginAdmin",
  props: {
    source: String,
  },
  data() {
    return {
      login: {
        email: "",
        password: "",
      },
      register: {
        email: "",
        password: "",
        phonenumber: "",
        address: "",
        name: "",
      },
      role: {
        nameRules: [
          (v) => !!v || "Tên không được để trống",
          (v) => v.length <= 35 || "Tên phải ít hơn 35 kí tự",
        ],

        emailRules: [
          (v) => !!v || "E-mail không được để trống",
          (v) => /.+@.+/.test(v) || "E-mail phải hợp lệ",
        ],

        addressRules: [(v) => !!v || "Địa chỉ không được để trống"],

        phonenumberRules: [
          (v) => !!v || "Số điện thoại không được để trống",
          (v) => v.length <= 10 || "Số điện thoại phải ít hơn 10 kí tự",
        ],

        passwordRules: [
          (v) => !!v || "Mật khẩu không được để trống",
          (v) => v.length >= 8 || "Mật khẩu phải hơn 8 ký tự",
        ],
      },
      showPassword: false,
      step: 1,
      show: true,
      checkbox: false,
      isActive: false,
      message: "",
    };
  },

  methods: {
    onLogin(event) {
      event.preventDefault();

      this.isActive = !this.isActive;
      const login = new FormData();
      login.append("email", this.login.email);
      login.append("password", this.login.password);

      this.axios
        .post("http://127.0.0.1:8000/api/login", login)
        .then((response) => {
          this.isActive = !this.isActive;
          localStorage.token = response.data.token;
           this.$store.dispatch("role", response.data.role);
          this.$store.dispatch("login", response.data.user);
          if(response.data.role != 1)
          {
              alert("Bạn không có quyền truy cập");
          }
          else{
              this.$router.push("/admin");
          }
        })
        .catch((error) => {
          this.isActive = !this.isActive;
          if (error.response.status == 422) {
            this.message = error.response.data.errors.email[0];
          } else {
            this.message = error.response.data.message;
          }
          console.clear();
        });
    },
    onRegister(event) {
      event.preventDefault();
      this.isActive = !this.isActive;
      const register = new FormData();
      register.append("email", this.register.email);
      register.append("password", this.register.password);
      register.append("address", this.register.address);
      register.append("phonenumber", this.register.phonenumber);
      register.append("name", this.register.name);
      this.axios
        .post("http://127.0.0.1:8000/api/register", register)
        .then((response) => {
          this.isActive = !this.isActive;
          alert(response.data.message);
          this.$router.go();
        })
        .catch((error) => {
          alert(error.message);
        });
    },
  },
};
</script>
<style lang="scss" scoped>
.v-application .rounded-bl-xl {
  border-bottom-left-radius: 300px !important;
}
.v-application .rounded-br-xl {
  border-bottom-right-radius: 300px !important;
}
.login {
  margin-top: -3%;
}
</style>
