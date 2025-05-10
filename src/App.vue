<script setup>
import {RouterView} from 'vue-router'
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'
import NavBar from './components/NavBar.vue'

</script>

<template>
  <div class="layout">
  <!--Header-->
  <Header></Header>
  
  <!--Nav-->
  <NavBar></NavBar>

  <!--Views-->
  <div class="main-content">
    <!--RouterView-->
  <RouterView ></RouterView>
  </div>

  <!--Footer-->
  <Footer></Footer>
</div>
</template>

<style scoped>
.layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.main-content {
  flex: 1;
}
</style>