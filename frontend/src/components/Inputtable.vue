<template>
  <div class="col-lg-12 col-md-12 col-sm-12">
    <router-link v-if="isAdd" :to="link">
      <b-button pill class="add">
        <b-icon icon="plus" scale="2" variant="white"></b-icon>
      </b-button>
    </router-link>

    <b-modal
      id="modal-center-sua"
      centered
      title="Sửa danh mục"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk"
      ok-only
      ok-title="Sửa"
      ok-variant="warning"
      footer-border-variant="white"
      header-border-variant="white"
    >
      <form ref="form" @submit.stop.prevent="handleSubmit" method="put">
        <b-form-group
          invalid-feedback="Tên danh mục không được để trống"
          :state="nameState"
        >
          <b-form-input
            id="name-input"
            v-model="updatecategory.name"
            :state="nameState"
            placeholder="Tên danh mục"
            required
          ></b-form-input>
        </b-form-group>
      </form>
    </b-modal>
    <b-table hover :items="items" :fields="fields" v-if="items.length != 0">
      <template v-slot:cell(action)="data">
        <!-- Sửa danh mục -->
        <b-button
          v-if="actions == 'danhmuc'"
          variant="warning"
          size="sm"
          class="mr-1"
          @click="updateCategory(data.item.id)"
          v-b-modal.modal-center-sua
          >Sửa </b-button
        >&nbsp;
        <!-- Xóa danh mục -->
        <b-button
          v-if="actions == 'danhmuc'"
          variant="danger"
          size="sm"
          class="mr-1"
          @click="deleteCategory(data.item.id)"
        >
          Xóa
        </b-button>

        <!-- Xem chi tiết sản phẩm -->
        <router-link
          :to="{ name: 'productdetail', params: { url: data.item.id } }"
          data-tip="Xem chi tiết sản phẩm"
        >
          <b-button
            v-if="actions == 'sanpham'"
            variant="primary"
            size="sm"
            class="mr-1"
            >Xem chi tiết</b-button
          > </router-link
        >&nbsp;

        <!-- Sửa sản phẩm -->
        <router-link
          :to="{ name: 'updateproduct', params: { url: data.item.id } }"
          data-tip="Sửa sản phẩm"
        >
          <b-button
            v-if="actions == 'sanpham'"
            variant="warning"
            size="sm"
            class="mr-1"
            >Sửa</b-button
          > </router-link
        >&nbsp;

        <!-- Xóa sản phẩm -->
        <b-button
          v-if="actions == 'sanpham'"
          variant="danger"
          size="sm"
          class="mr-1"
          @click="deleteProduct(data.item.id)"
          >Xóa</b-button
        >
      </template>
    </b-table>

    <Loading v-else />
  </div>
</template>

<script>
import Loading from "@/components/Loading";
export default {
  props: {
    items: Array,
    fields: Array,
    isAdd: {
      default: true,
      typeof: Boolean,
    },
    link: String,
    actions: String,
  },
  name: "Inputtable",
  data() {
    return {
      nameState: null,
      updatecategory: {
        name: "",
      },
    };
  },
  methods: {
    deleteCategory(id) {
      this.axios
        .delete("http://127.0.0.1:8000/api/category/" + id)
        .then(() => {
          this.$emit("render");
          alert("Xóa thành công!!");
        })
        .catch(() => {
          console.clear();
          alert("Danh mục này không thể xóa!!");
        });
    },

    deleteProduct(id) {
      this.axios
        .delete("http://127.0.0.1:8000/api/product/" + id)
        .then(() => {
          this.$emit("render");
          alert("Xóa thành công!!");
        })
        .catch(() => {
          alert("Sản phẩm này không thể xóa!!");
          console.clear();
        });
    },

    updateCategory(id) {
      this.axios
        .get("http://127.0.0.1:8000/api/category/" + id)
        .then((response) => {
          this.updatecategory = response.data;
        })
        .catch((error) => {
          alert(error);
        });
    },
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      this.nameState = valid;
      return valid;
    },
    resetModal() {
      this.updatecategory.name = "";
      this.nameState = null;
    },
    handleOk(bvModalEvt) {
      // Ngăn chặn phương thức đóng
      bvModalEvt.preventDefault();
      // Xử lý sự kiện handleSubmit
      this.handleSubmit();
    },
    handleSubmit() {
      // Thoát khỏi form có giá trị sai
      if (!this.checkFormValidity()) {
        return;
      } else {
        this.axios
          .put(
            "http://127.0.0.1:8000/api/category/" + this.updatecategory.id,
            this.updatecategory
          )
          .then(() => {
            this.$emit("render");
            alert("Sửa thành công");
          })
          .catch((error) => {
            alert(error);
          });
      }
      // Ẩn model
      this.$nextTick(() => {
        this.$bvModal.hide("modal-center-sua");
      });
    },
  },
  components: { Loading },
};
</script>

<style lang="scss" scoped>
.add {
  background-color: green;
  margin: 10px;
}
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
</style>
