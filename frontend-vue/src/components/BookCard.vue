<template>
  <MDBContainer>
    <MDBInput
      v-model="search"
      inputGroup
      :formOutline="false"
      wrapperClass="mb-3 mt-3"
      placeholder="Search"
      aria-label="Search"
      aria-describedby="button-addon2"
      @keyup.enter="onSearch(search)"
    >
    <MDBBtn color="primary" @click="onSearch(search)">
      <MDBIcon icon="search" />
    </MDBBtn>
    </MDBInput>
    <div>
      <MDBRow class="book-container">
        <MDBCol v-for="(book, index) in books" :key="book.id" col="4">
          <MDBCard :key="index" class="book-card">
            <section class="book">
              <img src="https://picsum.photos/200/300" alt="Normans How are." />
              <h3>
                Name: <span>{{ book.title }}</span>
              </h3>
              <h4>
                Author: <span>{{ book.author }}</span>
              </h4>
              <h4>
                Isbn: <span>{{ book.isbn }}</span>
              </h4>
              <h4>
                Genre: <span>{{ book.genre }}</span>
              </h4>
              <h4>
                Description:
                <span>{{ book.description }}</span>
              </h4>
              <div v-if="loggedIn && admin" >
                <MDBBtn  color="primary" @click="handleEditBook(book.id)">
                  <MDBIcon icon="edit" />
                </MDBBtn>
                <MDBBtn color="danger" @click="handleDeleteBook(book.id)">
                  <MDBIcon icon="trash" />
                </MDBBtn>
              </div>
            </section>
          </MDBCard>
        </MDBCol>
      </MDBRow>
    </div>
    <div v-if="loading">
      <p>Loading more data...</p>
    </div>

    <div class="pagination-container mb-4">
      <MDBBtn color="primary" @click="previousPage" :disabled="currentPage === 1">
        Previous
      </MDBBtn>
      <MDBBtn color="primary" @click="nextPage" :disabled="books.length === 0">
        Next
      </MDBBtn>
    </div>
    
  </MDBContainer>


</template>

<script>
import {  deleteBook } from "@/api";
import { computed } from 'vue';
import { useStore } from 'vuex';
import { useToast } from "vue-toast-notification";

import {
  MDBCol,
  MDBContainer,
  MDBRow,
  MDBCard,
  MDBInput,
  MDBBtn,
  MDBIcon,
} from "mdb-vue-ui-kit";
// import { ref } from "vue";
import { ApiService } from "../api";
import router from "@/router";

const $toast = useToast();
export default {
  name: "Book-Card",
  components: {
    MDBCol,
    MDBRow,
    MDBContainer,
    MDBCard,
    MDBInput,
    MDBBtn,
    MDBIcon,
  },
  data() {
    return {
      books: [],
      loading: false,
      currentPage: 1,
      refToBottomElement: null,
      search:""
    };
  },
  setup() {
    const store = useStore();
    const loggedIn = computed(() => store.state.loggedIn);
    const admin = computed(() => store.state.admin);
    const handleEditBook = (id) => {
      router.push(`/editBook/${id}`)
    };

    return {   
      loggedIn,
      admin,
      handleEditBook
    }
  },
  mounted() {
  this.fetchBooks();
},
  methods: {
    fetchBooks() {
      this.loading = true;

      // Fetch the next page of data
      ApiService.get("books?page=" + this.currentPage+"&query="+this.search)
        .then(response => {
          // Append the new data to the existing data
          this.books = response.data.data.books;

          // Set the loading variable to false
          this.loading = false;
        })
        .catch(error => {
          // Handle error
          console.log(error);
        });
    },
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.fetchBooks();
      }
    },
    nextPage() {
      this.currentPage++;
      this.fetchBooks();
    },
    onSearch(search){
      this.search = search;
      this.currentPage = 1;
      this.fetchBooks();
    },
    handleDeleteBook(id){
      const token = localStorage.getItem("authToken");
      deleteBook(token, id)
          .then((response) => {
            // Handle success response
            console.log("response", response);
            $toast.success("Book deleted Successfully.", {
              // optional options Object
            });
            this.currentPage = 1;
            this.fetchBooks();
          })
          .catch((error) => {
            // Handle error response
            console.log("error", error);
      });
    }
  },
};

</script>
<style scoped>
.book-card {
  padding: 1rem;
}

.book-card span {
  font-style: italic;
  color: #777;
}

.book img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.book h3,
.book h4 {
  margin-top: 0;
  margin-bottom: 0.5rem;
}

.book h3 {
  font-size: 1.2rem;
  font-weight: bold;
}

.book h4 {
  font-size: 1rem;
}

.book p {
  font-size: 0.8rem;
  line-height: 1.2rem;
}

.book-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  margin-top: 1rem;
}

.book-container .book {
  margin-bottom: 1rem;
}

.pagination-container {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.pagination-container span {
  margin: 0 10px;
}

@media (max-width: 768px) {
  .book-container {
    flex-direction: column;
  }

  .book-container .book {
    margin-right: 0;
    width: 100%;
  }

  .book-card {
    width: 100%;
    margin-right: 0;
  }
}
</style>
