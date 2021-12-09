<template>
  <div class="container page-loader">
    <div class="row">
      <div class="col-md-12">
        <div class="loader7" >
          <span class="loader-inner-1"></span>
          <span class="loader-inner-2"></span>
          <span class="loader-inner-3"></span>
          <span class="loader-inner-4"></span>
          
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Loading',
};
</script>

<style lang="scss" scoped>
.page-loader{
  // display: flex;
  // justify-content: center;
  // align-items: center;
  
  position: fixed;
  top: 90%;
  left: 45%;
  transform: translate(-50%,-50%);
  width: 100%;
  height: 100vh;
  background-color: transparent;
  z-index: 999;
  overflow: hidden;
}
.loader7 {
  width: 100px;
  height: 100px;
  margin: 50px auto;
  position: relative;
}
.loader7 .loader-inner-1,
.loader7 .loader-inner-2,
.loader7 .loader-inner-3,
.loader7 .loader-inner-4 {
  display: block;
  width: 20px;
  height: 20px;
  border-radius: 20px;
  position: absolute;
}
.loader7 .loader-inner-1:before,
.loader7 .loader-inner-2:before,
.loader7 .loader-inner-3:before,
.loader7 .loader-inner-4:before {
  content: "";
  display: block;
  width: 20px;
  height: 20px;
  border-radius: 20px;
  position: absolute;
  right: 0;
  animation-name: loading-7;
  animation-iteration-count: infinite;
  animation-direction: normal;
  animation-duration: 2s;
}
.loader7 .loader-inner-1 {
  top: 0;
  left: 0;
  transform: rotate(70deg);
}
.loader7 .loader-inner-1:before {
  background: #06aed5;
}
.loader7 .loader-inner-2 {
  top: 0;
  right: 0;
  transform: rotate(160deg);
}
.loader7 .loader-inner-2:before {
  background: #ec008c;
}
.loader7 .loader-inner-3 {
  bottom: 0;
  right: 0;
  transform: rotate(-110deg);
}
.loader7 .loader-inner-3:before {
  background: #ffbf00;
}
.loader7 .loader-inner-4 {
  bottom: 0;
  left: 0;
  transform: rotate(-20deg);
}
.loader7 .loader-inner-4:before {
  background: #079c00;
}
@keyframes loading-7 {
  0% {
    width: 20px;
    right: 0;
  }
  30% {
    width: 120px;
    right: -100px;
  }
  60% {
    width: 20px;
    right: -100px;
  }
}
</style>