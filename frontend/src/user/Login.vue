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

                            <v-row>
                              <v-col cols="12" sm="7">
                                <v-checkbox
                                  label="Nhớ mật khẩu"
                                  class="mt-n1"
                                  color="blue"
                                >
                                </v-checkbox>
                              </v-col>
                            </v-row>
                            <v-btn color="black" dark block tile type="submit"
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

                  <v-col cols="12" md="6" class="black rounded-bl-xl ">
                    <div style="text-align: center; padding: 180px 0; ">
                      <v-card-text class="white--text">
                        <h3 class="text-center ">Bạn chưa có tài khoản?</h3>
                        <h6 class="text-center">
                          Tạo tài khoản của bạn để trở thành một phần của thế
                          giới BaYe-Jewellery, khám phá các bộ sưu tập mới, tin
                          tức của chúng tôi.
                        </h6>
                      </v-card-text>
                      <div class="text-center">
                        <v-btn tile outlined dark @click="step++"
                          >TẠO TÀI KHOẢN</v-btn
                        >
                      </div>
                    </div>
                  </v-col>
                </v-row>
              </v-window-item>
              <v-window-item :value="2">
                <v-row>
                  <v-col cols="12" md="6" class="black rounded-br-xl">
                    <div style="  text-align: center; padding: 180px 0;">
                      <v-card-text class="white--text">
                        <h3 class="text-center ">Bạn đã có tài khoản?</h3>
                        <h6 class="text-center">
                          Vui lòng đăng nhập tài khoản của bạn.
                        </h6>
                      </v-card-text>
                      <div class="text-center">
                        <v-btn tile outlined dark @click="step--"
                          >ĐĂNG NHẬP</v-btn
                        >
                      </div>
                    </div>
                  </v-col>

                  <v-col cols="12" md="6">
                    <v-card-text class="mt-12">
                      <h4 class="text-center">TẠO TÀI KHOẢN MỚI</h4>
                      <h6 class="text-center  grey--text ">
                        Bạn sẽ nhận được email xác nhận thông tin
                        <br />
                        và trở thành thành viên của chúng tôi
                      </h6>
                      <v-row align="center" justify="center">
                        <v-col cols="12" sm="10">
                          <v-form
                            class="register"
                            v-model="valid"
                            lazy-validation
                            @submit="onRegister"
                          >
                            <v-row>
                              <v-col cols="12" sm="6">
                                <v-text-field
                                  v-model="register.name"
                                  label="Tên người dùng"
                                  outlined
                                  dense
                                  color="blue"
                                  autocomplete="false"
                                  class="mt-4"
                                  :counter="35"
                                  :rules="role.nameRules"
                                  required
                                />
                              </v-col>
                              <v-col cols="12" sm="6">
                                <v-text-field
                                  v-model="register.phonenumber"
                                  counter="10"
                                  label="Số điện thoại"
                                  outlined
                                  dense
                                  color="blue"
                                  autocomplete="false"
                                  :rules="role.phonenumberRules"
                                  class="mt-4"
                                  required
                                />
                              </v-col>
                            </v-row>
                            <v-text-field
                              v-model="register.email"
                              label="Email"
                              :rules="role.emailRules"
                              outlined
                              dense
                              color="blue"
                              autocomplete="false"
                              required
                            />
                            <v-text-field
                              v-model="register.address"
                              :rules="role.addressRules"
                              label="Địa chỉ"
                              :counter="100"
                              outlined
                              dense
                              color="blue"
                              autocomplete="false"
                              required
                            />
                            <v-text-field
                              v-model="register.password"
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
                            <v-row>
                              <v-col cols="12" sm="7">
                                <v-checkbox
                                  v-model="checkbox"
                                  :rules="[
                                    (v) =>
                                      !!v || 'Bạn phải chấp nhận để tiếp tục!',
                                  ]"
                                  label="Tôi chấp nhận"
                                  class="mt-n1"
                                  color="blue"
                                >
                                </v-checkbox>
                              </v-col>
                            </v-row>
                            <!-- <v-btn color="error" @click="reset">
                              Nhập lại
                            </v-btn> -->
                            <v-btn color="black" dark block tile type="submit"
                              >TẠO TÀI KHOẢN</v-btn
                            >
                            
                          </v-form>
                        </v-col>
                      </v-row>
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
          this.$store.state.name = response.data.user.name;
          this.$router.push("/");
        
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
