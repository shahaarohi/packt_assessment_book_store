<template>
  <MDBContainer>
    <div class="row align-items-center">
      <div class="col-md-6 offset-md-3"></div>
      <form class="book-form" novalidate @submit.prevent="checkForm">
        <MDBInput
          type="input"
          label="Book Title"
          id="title"
          v-model="bookTitle"
          @input="updateBookData('title', $event.target.value)"
          wrapperClass="mb-4"
          validationEvent="input"
          invalidFeedback="Title is required"
          required
          maxLength="100"
        />
        <MDBInput
          type="input"
          label="Book Author"
          id="author"
          v-model="bookAuthor"
          @input="updateBookData('author', $event.target.value)"
          wrapperClass="mb-4"
          validationEvent="input"
          invalidFeedback="Author is required"
          required
          maxLength="50"
        />
        <MDBInput
          :formOutline="false"
          type="file"
          label="Book Image"
          id="bookImage"
          v-model="bookImageUpdate"
          @input="updateBookData('bookImage', $event.target)"
          wrapperClass="mb-4"
          validationEvent="input"
          invalidFeedback="Image is required"
          required
        />
        <MDBTextarea
          label="Book Description"
          rows="4"
          id="description"
          v-model="bookDescription"
          @input="updateBookData('description', $event.target.value)"
          wrapperClass="mb-4"
        />

        <MDBInput
          type="input"
          label="Book Publisher"
          id="publisher"
          v-model="bookPublisher"
          @input="updateBookData('publisher', $event.target.value)"
          wrapperClass="mb-4"
          validationEvent="input"
          invalidFeedback="Publisher is required"
          required
          maxLength="100"
        />

        <MDBInput
          type="input"
          label="Book Genre"
          id="genre"
          v-model="bookGenre"
          @input="updateBookData('genre', $event.target.value)"
          wrapperClass="mb-4"
          validationEvent="input"
          invalidFeedback="Genre is required"
          required
          maxLength="50"
        />

        <MDBInput
          type="input"
          label="Book ISBN with 13 digit"
          id="isbn"
          v-model="bookIsbn"
          @input="updateBookData('isbn', $event.target.value)"
          wrapperClass="mb-4"
          validationEvent="input"
          invalidFeedback="ISBN must be a 13-digit number"
          required
          pattern="\d{13}"
        />

        <MDBInput
          type="date"
          label="Book Published"
          id="publishedDate"
          v-model="bookPublishedDate"
          @input="updateBookData('publishedDate', $event.target.value)"
          wrapperClass="mb-4"
          validationEvent="date"
          invalidFeedback="Date Published is required"
          required
        />
        <MDBBtn color="primary" type="submit"> Book Details Save </MDBBtn>
      </form>
    </div>
  </MDBContainer>
</template>

<script>
import { addNewBook, editBook } from "@/api";
import router from "@/router";
import { useRoute } from "vue-router";
import { useToast } from "vue-toast-notification";
import { MDBBtn, MDBContainer, MDBInput, MDBTextarea } from "mdb-vue-ui-kit";
import { ref } from "vue";
const title = ref("");
const author = ref("");
const bookImage = ref("");
const description = ref("");
const publisher = ref("");
const genre = ref("");
const publishedDate = ref("");
const isbn = ref("");
const $toast = useToast();

export default {
  name: "Add-New",
  props: {
    books: Object,
  },
  setup() {
    const route = useRoute();
    const currentPath = route.name;
    const currentId = route?.params?.id;

    console.log("currentPath", currentPath, currentId);
    const checkForm = () => {
      const token = localStorage.getItem("authToken");
      const formData = new FormData();
      formData.append("title", title?.value);
      formData.append("author", author?.value);
      formData.append("publisher", publisher?.value);
      formData.append("description", description?.value);
      formData.append("genre", genre?.value);
      formData.append("isbn", isbn?.value);
      formData.append("published", publishedDate?.value);
      formData.append("image", bookImage?.value);
      if (currentPath !== "EditBook") {
        addNewBook(token, formData)
          .then((response) => {
            // Handle success response
            console.log("response", response);
            $toast.success("New Book Added Successfully.", {
              // optional options Object
            });
            router.push("/");
            //this.books = response.data.data.books;
          })
          .catch((error) => {
            // Handle error response
            console.log("error", error);
          });
      } else {
        editBook(token, currentId, formData)
          .then((response) => {
            // Handle success response
            console.log("response", response);
            $toast.success("Book Edited Successfully.", {
              // optional options Object
            });
            router.push("/");
            //this.books = response.data.data.books;
          })
          .catch((error) => {
            // Handle error response
            console.log("error", error);
          });
      }
    };

    return {
      title,
      author,
      bookImage,
      description,
      publisher,
      genre,
      publishedDate,
      isbn,
      checkForm,
      currentPath,
    };
  },
  computed: {
    bookTitle() {
      title.value = this.books?.title;
      return this.books?.title;
    },
    bookAuthor() {
      author.value = this.books?.author;
      return this.books?.author;
    },
    bookImageUpdate() {
      // bookImage.value = this.books?.bookImage;
      return this.books?.bookImage;
    },
    bookDescription() {
      description.value = this.books?.description;
      return this.books?.description;
    },

    bookPublisher() {
      publisher.value = this.books?.publisher;
      return this.books?.publisher;
    },

    bookGenre() {
      genre.value = this.books?.genre;
      return this.books?.genre;
    },

    bookPublishedDate() {
      publishedDate.value = this.books?.published;
      return this.books?.published;
    },

    bookIsbn() {
      isbn.value = this.books?.isbn;
      return this.books?.isbn;
    }
  },
  methods: {
    updateBookData(type, newValue) {
      if (type === "title") {
        this.title = newValue;
      } else if (type === "author") {
        this.author = newValue;
      } else if (type === "bookImage") {
        console.log("new title", newValue.files[0]);

        this.bookImage = newValue.files[0];
      } else if (type === "description") {
        this.description = newValue;
      } else if (type === "publisher") {
        this.publisher = newValue;
      } else if (type === "genre") {
        this.genre = newValue;
      } else if (type === "publishedDate") {
        this.publishedDate = newValue;
      } else if (type === "isbn") {
        this.isbn = newValue;
      }
    },
  },
  components: { MDBInput, MDBContainer, MDBBtn, MDBTextarea },

};
</script>
<style scoped>
.book-form {
  margin-top: 50px;
  padding: 20px;
  border: 1px solid #ccc;
}

.book-form h1 {
  text-align: center;
}

.book-form input {
  width: 100%;
  margin-bottom: 10px;
}

.book-form button {
  width: 100%;
  background-color: blue;
  color: white;
  border: none;
  padding: 10px;
}

@media (max-width: 576px) {
  .book-form {
    margin-top: 20px;
  }
}
</style>
