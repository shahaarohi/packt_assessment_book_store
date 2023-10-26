<template>
  <HeaderView />
  <Add-New v-bind:books="books"/>
</template>

<script>
// @ is an alias to /src
import HeaderView from "@/components/Header.vue";
import AddNew from "@/components/AddBook.vue";
import { ApiService } from "@/api";
import { ref } from "vue";

export default {
  name: "editBook",
  components: {
    HeaderView,
    "Add-New": AddNew,
  },
  mounted() {
    console.log("params", this.$route);
    ApiService.get(`books/${this.$route?.params?.id}`)
      .then((response) => {
        // Handle success response
        console.log("response", response.data.data);
        this.books = response.data.data
      })
      .catch((error) => {
        // Handle error response
        console.log("error", error);
        this.books = {
          id: 1,
          title: "And in she went.",
          author: "Theron Kling",
          genre: "Voluptas",
          description:
            "I'd better take him his fan and gloves. 'How queer it seems,' Alice said very humbly; 'I won't interrupt again. I dare say there may be different,' said Alice; 'you needn't be so easily offended!'.",
          isbn: "9791755648388",
          image: "http://placeimg.com/480/640/any",
          published: "1998-12-01",
          publisher: "Harum Ad",
        };
      });
  },
  setup() {
    const books = ref("");
    return {
      books,
    };
  },
};
</script>