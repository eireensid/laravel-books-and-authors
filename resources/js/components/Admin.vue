<template>
  <div>
    <h2 class="mb-3">Книга и автор</h2>
    <div class="container">
      <div class="row mb-3">
        <div class="col-5 input-block">
          <input class="form-control" type="text" v-model="newBook.name">
        </div>
        <div class="col-3">
          <select class="form-control" v-model="newBook.author_id">
            <option :value="null">Выбрать автора</option>
            <option v-for="a in authors" :key="'o' + a.id" :value="a.id">
              {{a.name}}
            </option>
        </select>
        </div>
        <div class="col-2">
          <button class="btn btn-success" @click="addBook">Добавить книгу</button>
        </div>
      </div>
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">Книга</th>
          <th scope="col">Автор</th>
          <th scope="col">Изменение книг</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(book, ind) in books" :key="'book' + book.id">
          <td><input class="form-control" type="text" v-model="book.name"></td>
          <td>{{ getAuthorName(book) }}</td>
          <td>
            <button class="btn btn-change btn-primary ml-2" @click="updateBook(book)">
              <div class="save-wrapper">
                <img src="img/save.svg"/>
              </div>
            </button>
            <button class="btn btn-change btn-danger ml-2" @click="deleteBook(book, ind)">X</button>
          </td>
        </tr>
      </tbody>
    </table>

    <h2 class="mb-3 mt-5">Автор и количество книг</h2>
    <div class="container">
      <div class="row mb-3">
        <div class="col-5 input-block">
          <input class="form-control" type="text" v-model="newAuthor.name">
        </div>
        <div class="col-2">
          <button class="btn btn-success" @click="addAuthor">Добавить автора</button>
        </div>
      </div>
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">Автор</th>
          <th scope="col">Количество книг</th>
          <th scope="col">Изменение авторов</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="author in authors" :key="'author' + author.id">
          <td><input class="form-control" type="text" v-model="author.name"></td>
          <td>{{ author.books ? author.books.length : '' }}</td>
          <td>
            <button class="btn btn-change btn-primary ml-2" @click="updateAuthor(author)">
              <div class="save-wrapper">
                <img src="img/save.svg"/>
              </div>
            </button>
            <button class="btn btn-change btn-danger ml-2" data-toggle="modal" data-target="#exampleModal"
              @click="rememberDeleteAuthor(author)">X</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Предупреждение</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            При удалении автора так же будут удалены все его книги
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="deleteAuthor">Да</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import axios from 'axios'
  import _ from 'lodash'
  import $ from "jquery"

  export default {
    name: 'admin',
    data () {
      return {
        books: [],
        authors: [],
        newBook: {
          name: '',
          author_id: null
        },
        newAuthor: {
          name: ''
        },
        authorDelete: null
      }
    },
    created() {
      axios.get('/api/v1/books/list').then(response => {
        this.books = response.data;
      }),
      axios.get('/api/v1/authors/list').then(response => {
        this.authors = response.data;
      })
    },
    methods: {
      addBook () {
        if (!this.newBook.name || this.newBook.author_id === null) {
          alert('Не выбрано название или автор у книги')
          return
        }
        axios.post('/api/v1/books/add', this.newBook)
          .then((resp) => {
            const newBook = resp.data
            this.books.push(newBook)
            const author = this.authors.find(a => a.id === newBook.author_id)
            author.books.push(_.cloneDeep(newBook))
            alert('Новая книга добавлена')
            this.newBook = {
              name: '',
              author_id: null
            }
          })
          .catch(function (resp) {
            console.log(resp);
            alert("Невозможно добавить книгу");
          })
      },
      updateBook (book) {
        axios.post('/api/v1/books/update', book)
          .then((resp) => {
            alert('Книга отредактирована')
          })
          .catch(function (resp) {
            console.log(resp);
            alert("Невозможно отредактировать книгу");
          })
      },
      deleteBook (book, ind) {
        axios.delete(`/api/v1/books/id/${book.id}`)
          .then((resp) => {
            this.books.splice(ind, 1)
            const author = this.authors.find(a => a.id === book.author_id)
            const bookIndex = author.books.findIndex(b => b.id === book.id)
            author.books.splice(bookIndex, 1)
            alert('Книга удалена')
          })
          .catch(function (resp) {
            console.log(resp);
            alert("Не удалось удалить книгу")
          })
      },
      addAuthor () {
        axios.post('/api/v1/authors/add', this.newAuthor)
          .then((resp) => {
            const newAuthor = resp.data
            this.authors.push(newAuthor)
            alert('Новый автор добавлен')
          })
          .catch(function (resp) {
            console.log(resp);
            alert("Невозможно добавить автора");
          })
        this.newAuthor = {
          name: ''
        }
      },
      updateAuthor (author) {
        axios.post('/api/v1/authors/update', author)
          .then((resp) => {
            alert('Автор отредактирован')
          })
          .catch(function (resp) {
            console.log(resp);
            alert("Невозможно отредактировать автора");
          })
      },
      async deleteAuthor () {
        $('#exampleModal').modal('hide')
        const author = this.authorDelete
        try {
          await axios.delete(`/api/v1/authors/id/${author.id}`)
          author.books.forEach(book => {
            const bookIndex = this.books.findIndex(b => b.id === book.id)
            this.books.splice(bookIndex, 1)
          })
          let index = this.authors.findIndex(a => a.id === author.id)
          this.authors.splice(index, 1);
          alert('Автор удален')
        } catch (err) {
          console.log(err);
          alert("Не удалось удалить автора")
        }
      },
      rememberDeleteAuthor (author) {
        console.log('rememberDeleteAuthor', author)
        this.authorDelete = author
      },
      getAuthorName (book) {
        let index = this.authors.findIndex(a => a.id === book.author_id)
        if (index === -1) return ''
        return this.authors[index].name
      }
    }
  }
</script>

<style lang="scss" scoped>
  .input-block {
    padding-left: 0;
    padding-right: 0;
  }
  .save-wrapper {
    display: flex;
    justify-content: center;
  }
  .btn-change {
    width: 40px;
    height: 40px;
  }
</style>