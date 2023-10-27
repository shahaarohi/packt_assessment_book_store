<template>
  <MDBContainer>
    <div class="row align-items-center">
      <div class="col-md-6 offset-md-3">
        <form class="login-form" novalidate @submit.prevent="checkForm" @submit="handleLogin">
          <h1>Login</h1>
          <!-- Email input -->
          <MDBInput
            type="email"
            label="Email address"
            id="email"
            v-model="email"
            wrapperClass="mb-4"
            validationEvent="input"
            invalidFeedback="Email is required"
            required
            pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
          />
          <!-- Password input -->
          <MDBInput
            type="password"
            label="Password"
            id="password"
            v-model="password"
            wrapperClass="mb-4"
            validationEvent="input"
            invalidFeedback="Password is required"
            required

          />
          <!-- Submit button -->
          <MDBBtn color="primary" type="submit"> Sign in </MDBBtn>
        </form>
      </div>
    </div>
  </MDBContainer>
</template>

<script>
import { MDBContainer, MDBInput, MDBBtn } from "mdb-vue-ui-kit";
import { useToast } from "vue-toast-notification";
import { ref } from "vue";
const $toast = useToast();

export default {
  name: "LoginAdmin",
  components: {
    MDBContainer,
    MDBInput,
    MDBBtn,
  },
  setup() {
    const email = ref("");
    const password = ref("");
    
    const checkForm = (event) => {
    event.target.classList.add('was-validated');
  };
    return {
      email,
      password,
      checkForm
    };
  },
  methods: {
    async handleLogin() {
      const response = await this.$store.dispatch('login', {
        email: this.email,
        password: this.password,
      });
      if (response.success) {
        this.$router.push('/');
      } else {
        // alert(response);
        $toast.error(response, {
              // optional options Object
        });
      }
    },
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.login-form {
  margin-top: 50px;
  padding: 20px;
  border: 1px solid #ccc;
}

.login-form h1 {
  text-align: center;
}

.login-form input {
  width: 100%;
  margin-bottom: 10px;
}

.login-form button {
  width: 100%;
  background-color: blue;
  color: white;
  border: none;
  padding: 10px;
}

@media (max-width: 576px) {
  .login-form {
    margin-top: 20px;
  }
}
</style>
