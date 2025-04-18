<script setup>
import {RouterView} from 'vue-router'
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'
import NavBar from './components/NavBar.vue'

</script>

<template>
  <!--Header-->
  <Header></Header>
  
  <!--Nav-->
  <NavBar></NavBar>

  <!--Views-->
  <RouterView></RouterView>

  <!--Footer-->
  <Footer></Footer>
</template>

<style scoped></style>