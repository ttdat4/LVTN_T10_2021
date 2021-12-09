<template>
  <div class="search w-90">
    <b-icon icon="search"  ></b-icon>
    <input
      type="text"
      class="input-search"
      placeholder="Tìm kiếm sản phẩm, mã sản phẩm ..."
    />
  </div>
</template>

<script>
export default {
  name: "Inputsearch",
  data() {
    return {
      inputSearch: "",
    };
  }, 
};
</script>

<style scoped>
.search {
  height: 35px;
  background-color: white;
  border-radius: 30px;
  display: flex;
  align-items: center;
  padding: 20px;
}
.search svg {
  font-size: 20px;
  color: #777;
}
.search input {
  flex: 1;
  width: 100%;
  height: 40px;
  border: none;
  outline: none;
  font-size: 18px;
  padding-left: 10px;
}

/* Extra small devices (phones, 600px and down) */
@media only screen and (max-width: 600px) {
  .search {
    width: 108px;
  }
}

/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (min-width: 600px) {
  .search {
    width: 265px;
  }
}

/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {
  .search {
    width: 400px;
  }
}

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
  .search {
    width: 400px;
  }
}

/* Extra large devices (large laptops and desktops, 1200px and up) */
@media only screen and (min-width: 1200px) {
  .search {
    width: 500px;
  }
}
</style>