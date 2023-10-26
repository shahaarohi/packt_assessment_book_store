<template>
  <HeaderView />
  <LoginAdmin />
</template>

<script>
// @ is an alias to /src
import HeaderView from '@/components/Header.vue'
import LoginAdmin from '@/components/Login.vue'

export default {
  name: 'LoginView',
  components: {
    HeaderView,
    LoginAdmin
  }
}
</script>
