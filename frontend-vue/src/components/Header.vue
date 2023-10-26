<template>
 <header>
    <!-- Navbar -->
    <MDBNavbar expand="lg" light bg="white" container position="sticky">
        <MDBNavbarNav class="mb-2 mb-lg-0">
          <MDBNavbarItem to="/" > Book-Store </MDBNavbarItem>
          <MDBNavbarItem v-if="loggedIn && admin" to="/addBook"> Add New Book </MDBNavbarItem>
          <MDBNavbarItem v-if="!loggedIn" to="/login"> Login </MDBNavbarItem>
          <MDBNavbarItem v-else to="/login" @click="logout"> Logout </MDBNavbarItem>
        </MDBNavbarNav>
    </MDBNavbar>
    <!-- Navbar -->
  </header>
</template>

<script>
import { computed } from 'vue';
import { useStore } from 'vuex';

 import {
    MDBNavbar,
    MDBNavbarNav,
    MDBNavbarItem,
  } from 'mdb-vue-ui-kit';
  
export default {
  name: 'HeaderView',
  components : {
    MDBNavbar,
    MDBNavbarNav,
    MDBNavbarItem,
  },
  setup() {
    const store = useStore();
    const loggedIn = computed(() => store.state.loggedIn);
    const admin = computed(() => store.state.admin);
    
    const logout = () => {
      store.dispatch('logout');
    };

    return {   
      loggedIn,
      admin,
      logout
    }
    }
  };
</script>

<style scoped></style>