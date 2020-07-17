<template>
  <div>
    <p class="d-flex justify-content-center mb-4 mt-4">
      <router-link :to="{ name: 'home' }" class="mr-2" :class="{'active-link': routerPath === '/'}">Главная</router-link> |
      <router-link :to="{ name: 'admin' }"  class="ml-2" :class="{'active-link': routerPath === '/admin'}">Админ-панель</router-link>
    </p>

    <div class="container">
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
  export default {
    computed: {
      routerPath () {
        return this.$route.path
      }
    }
  }
</script>
<style lang="scss">
  a {
    color: black!important;
  }
  a:hover {
    text-decoration: none!important;
  }
  .active-link {
    border-bottom: 1px solid black;
  }
</style>