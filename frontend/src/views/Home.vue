<template>
  <v-app id="inspire">
    <Header />

    <v-main  id="home">
      <router-view/>
    </v-main>
    <Footer />
  </v-app>
</template>

<script>
import Footer from "../components/Footer.vue";
import Header from "../components/Header.vue";
export default {
  components: { Footer, Header },
};
</script>
<style scoped>
#home{
  margin-top: -3%;
}
</style>
