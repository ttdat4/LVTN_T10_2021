<template>
    <div id="app">
    <v-footer
      dark
      padless
    >
      <v-card
        flat
        tile
        class="text-center"
      >
        <v-card-text>
          <v-btn
            v-for="icon in icons"
            :key="icon"
            class="mx-4 "
            icon
          >
            <v-icon size="40px">
              {{ icon }}
            </v-icon>
          </v-btn>
        </v-card-text>
  
        <v-card-text class=" pt-1">

          BYJ là viết tắt của Bach Yen Jewelry với nguyện vọng là sản xuất kinh doanh trang sức bẳng vàng, bạc, đá quý, quà tặng doanh nghiệp, phụ kiện thời trang, quà lưu niệm, đồng hồ. Với slogan "Niềm tin và Phong cách" BYJ muốn khách hàng hãy tin tưởng ở chất lượng sản phẩm, dịch vụ và nhấn mạnh rằng các sản phẩm tại BYJ sẽ mang đến phong cách riêng cho khách hàng.  
            </v-card-text>
  
        <v-divide></v-divide>
    <!-- {{ new Date().getFullYear() }} -->
        <v-card-text class="">
        2022 — <strong>LVTN-ThànhĐạt-byTD</strong>
        </v-card-text>
      </v-card>
    </v-footer>
</div>
</template>

<script>
    export default {
        data: () => ({
    icons: [
      'mdi-facebook',
      'mdi-twitter',
      'mdi-linkedin',
      'mdi-instagram',
    ],
  }),
    }
</script>

<style lang="scss" scoped>

</style>