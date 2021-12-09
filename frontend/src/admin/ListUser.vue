<template>
  <div class="row h-100">
    <div class="col-md-12">
      <h3 class="title">DANH SÁCH KHÁCH HÀNG</h3>
    </div>

    <v-data-table
      :headers="headers"
      :items="listUser"
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
          
          
        </v-toolbar>
      </template>
      
    </v-data-table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      search: "",
      headers: [
        { text: "Mã khách hàng", align: "start", value: "id" },
        { text: "Tên khách hàng", value: "name", sortable: false },
        { text: "Email", value: "email", sortable: false },
        { text: "Địa chỉ", value: "address", sortable: false },
        { text: "Số điện thoại", value: "phonenumber", sortable: false },
      ],
      listUser: [], //biến lưu danh sách KH
    };
  },
  mounted() {
    this.axios
      .get("http://127.0.0.1:8000/api/listuser")
      .then((response) => {
        this.listUser = response.data;
      })
      .catch((error) => {
        this.message = error;
      });
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
