<template>
  <v-box>
    <div class="col-md-11 col-sm-10 mb-3">

      <div class="small mb-1">
        <a href="#">{{ comment.user.name }}</a>
        <span class="ml-2">{{ $humanTime(data.created_at) }}</span>
      </div>

      <div class="mb-2">
        {{ data.body }}
      </div>

      <div class="actions d-flex align-items-center">
        <votes-actions @vote="vote" :votes="data.votes" :voted="voted"></votes-actions>

        <a
          href="#"
          v-if="comment.page_id && $signedIn"
          @click.prevent="showForm"
          class="text-right small ml-3"
          style="text-decoration: none"
        >
          <i class="fas fa-reply"></i> Reply
        </a>
      </div>
    </div>

    <div class="col-md-11 offset-md-1 col-sm-10 offset-sm-2">
      <template v-if="comment.replies" v-for="comment in comment.replies">
        <comment :comment="comment"></comment>
      </template>
    </div>
  </v-box>

</template>

<script>
  import VBox from './VBox'
  import AddComment from './AddComment'
  import Comment from './Comment.vue'
  import VotesActions from './VotesActions'

  export default {
    name: 'Comment',

    components: {VBox, AddComment, Comment, VotesActions},

    props: ['comment'],

    computed: {
      voted () {
        if (this.$signedIn) {
          return this.data.user_votes.some(v => v.id === App.user.id)
        }
      }
    },

    data () {
      return {
        data: this.comment
      }
    },

    methods: {
      showForm () {
        this.$emit('form-visible', this.comment.id)
      },

      vote (type) {
        axios.post(`api/comments/${this.comment.id}/vote`, {
          'user_id': App.user.id,
          type
        })
          .then(resp => {
            this.data.votes = resp.data.votes

            this.data.user_votes = resp.data.user_votes
          })
          .catch(err => console.log(err))
      }
    },
  }
</script>
