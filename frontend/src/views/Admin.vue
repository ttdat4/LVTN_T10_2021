<template>
  <div class="admin">
    <div
      class="vertical-nav bg-white"
      id="sidebar"
      :class="isActive == true ? 'active' : ''"
    >
      <div class="py-4 px-3 mb-4 bg-light">
        <div class="media d-flex align-items-center">
          <div class="media-body">
            <h4 class="m-0">THÀNH ĐẠT</h4>
            <p class="font-weight-light text-muted mb-0">Administrator</p>
          </div>
        </div>
      </div>
      <div>
        <v-btn dark class="nav mb-3" to="/">
          BaYe-Jewellry-2611
        </v-btn>
      </div>
      <ul class="nav flex-column bg-white mb-0">
        <li class="nav-item">
          <router-link
            to="/admin/category"
            class="nav-link text-dark font-italic bg-light"
          >
            LOẠI SẢN PHẨM
          </router-link>
        </li>
        <li class="nav-item">
          <router-link
            to="/admin/product"
            class="nav-link text-dark font-italic bg-light"
          >
            SẢN PHẨM
          </router-link>
        </li>
        <li class="nav-item">
          <router-link
            to="/admin/supplier"
            class="nav-link text-dark font-italic bg-light"
          >
            NHÀ CUNG CẤP
          </router-link>
        </li>

        <li class="nav-item">
          <router-link
            to="/admin/user"
            class="nav-link text-dark font-italic bg-light"
          >
            KHÁCH HÀNG
          </router-link>
        </li>
        <li class="nav-item">
          <v-select
            v-model="activeInvoice"
            class="nav-link text-dark font-italic bg-light"
            :items="item"
            label="ĐƠN HÀNG"
            dense
            outlined
            item-value="key"
            item-text="name"
            @change="changeStatusInvoice"
          ></v-select>
        </li>
        <li class="nav-item">
          <router-link
            to="/admin/productpagetest"
            class="nav-link text-dark font-italic bg-light"
          >
            SẢN PHẨM Test
          </router-link>
        </li>
      </ul>
    </div>

    <div
      class="page-content p-5"
      id="content"
      :class="isActive == true ? 'active' : ''"
    >
      <nav class="nav">
        <button
          id="sidebarCollapse"
          type="button"
          class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4"
          @click="activeMenu"
        >
          <i class="fa fa-bars mr-8"></i>
        </button>
      </nav>
      <router-view />
    </div>
  </div>
</template>

<script>
export default {
  name: "Admin",
  data() {
    return {
      item: [
        { name: "Chưa xử lý", key: 0 },
        { name: "Đã xác nhận", key: 1 },
        { name: "Đang giao", key: 2 },
        { name: "Đã nhận hàng", key: 3 },
        { name: "Đơn bị hủy", key: 4 },
      ],
      isActive: false,
      activeInvoice: "0",
    };
  },
  computed: {
    role(){
      return this.$store.state.role;
    },
    listInvoice() {
      return this.$store.state.listInvoice;
    },
    filteredList() {
      return this.listInvoice.filter((item) => {
        if (item.status == this.activeInvoice) {
          return item;
        }
      });
    },
  },
  methods: {
    activeMenu() {
      this.isActive = !this.isActive;
    },
    changeStatusInvoice(){
      this.$store.dispatch("filteredList", this.filteredList);
      this.$router.push("/admin/invoice");
    },
  },

  created() {
    this.axios.get("http://127.0.0.1:8000/api/invoice").then((response) => {
      this.$store.dispatch("getInvoice", response.data.invoice);
    });
    if(this.role != 1)
    {
      alert("Bạn không có quyền truy cập!");
      this.$router.push("/loginAdmin");
    }
    else
    {
      this.$router.push("/admin");
    }
    
  },
};
</script>

<style scoped>
.vertical-nav {
  min-width: 17rem;
  width: 17rem;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.1);
  transition: all 0.4s;
}

.page-content {
  width: calc(100% - 17rem);
  margin-left: 17rem;
  transition: all 0.4s;
}

/* for toggle behavior */

#sidebar.active {
  margin-left: -17rem;
}

#content.active {
  width: 100%;
  margin: 0;
}

@media (max-width: 768px) {
  #sidebar {
    margin-left: -17rem;
  }
  #sidebar.active {
    margin-left: 0;
  }
  #content {
    width: 100%;
    margin: 0;
  }
  #content.active {
    margin-left: 17rem;
    width: calc(100% - 17rem);
  }
}

/*
*
* ==========================================
* FOR DEMO PURPOSE
* ==========================================
*
*/

body {
  background: #599fd9;
  background: -webkit-linear-gradient(to right, #599fd9, #c2e59c);
  background: linear-gradient(to right, #599fd9, #c2e59c);
  min-height: 100vh;
  overflow-x: hidden;
}</style
>>
