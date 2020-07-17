<template>
  <div>
    <h2 class="mb-3">Авторы и их книги</h2>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">Автор</th>
          <th scope="col">Книги</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="author in authorsWithBooks" :key="'author-tr-' + author.id">
          <td>{{ author.name }}</td>
          <td>
            <div v-for="book in author.books" :key="'book-div-' + book.id">
              {{book.name}}
            </div>
          </td></tr>
      </tbody>
    </table>

  </div>
</template>
<script>
  import axios from 'axios'
  export default {
    name: 'home',
    data () {
      return {
        authors: []
      }
    },
    created() {
      axios.get('/api/v1/authors/list').then(response => {
        this.authors = response.data;
      })
    },
    computed: {
      authorsWithBooks () {
        return this.authors.filter(a => a.books.length !== 0)
      }
    }
  }
</script>

<style scoped>
</style>
