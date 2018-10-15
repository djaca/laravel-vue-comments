<template>
  <div>
    <div class="mb-3">
      <add-comment v-if="$signedIn" :comment-url="commentUrl" @comment-added="add"></add-comment>

      <p v-else>You must be <a href="/login">signed in</a> in order to post a comment.</p>
    </div>

    <div class="border-bottom mb-4"></div>

    <div v-if="comments.length > 0">
      <template v-for="(comment, index) in comments">
        <comment :comment="comment" @form-visible="showForm" :key="index"></comment>

        <div class="row mb-2">
          <div class="comment-reply col-md-11 offset-md-1 col-sm-10 offset-sm-2">
            <add-comment
              v-if="$signedIn"
              v-show="replyForm === comment.id"
              :comment-url="comment.id"
              :is-reply=true
              @comment-added="add"
            ></add-comment>
          </div>
        </div>
      </template>
    </div>

    <div v-else>No comments</div>
  </div>
</template>

<script>
  import AddComment from './AddComment'
  import Comment from './Comment'

  export default {
    name: 'Comments',

    components: {AddComment, Comment},

    props: ['commentUrl'],

    data () {
      return {
        comments: null,
        replyForm: null
      }
    },

    methods: {
      showForm (id) {
        if (id === this.replyForm) {
          return this.replyForm = null
        }

        this.replyForm = id
      },

      fetch () {
        axios.get(`api/comments/${this.commentUrl}`)
          .then(({data}) => {
            this.comments = data
          })
      },

      add ({comment, isReply}) {
        let data = {
          id: comment.id,
          body: comment.body,
          page_id: !isReply ? comment.page_id : null,
          reply_id: isReply ? comment.reply_id : null,
          user_id: comment.user_id,
          created_at: comment.created_at,
          replies: [],
          user_votes: [],
          votes: 0,
          user: App.user,
        }

        if (isReply) {
          let parentIndex = this.comments.findIndex(c => c.id === comment.reply_id)

          this.replyForm = null

          this.comments[parentIndex].replies.push(data)

          return
        }

        this.comments.push(data)
      }
    },

    mounted () {
      this.fetch()
    }
  }
</script>
