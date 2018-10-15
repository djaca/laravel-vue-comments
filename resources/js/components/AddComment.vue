<template>
  <v-box>
    <div class="col-md-11 col-sm-10">
      <div>
        <div class="form-group">
          <textarea
            v-model="text"
            class="form-control"
            rows="3"
            placeholder="Add your comment..."
          ></textarea>
        </div>

        <button
          class="btn btn-primary btn-sm"
          @click="submit"
          :disabled="btnDisabled"
        >
          Submit
        </button>
      </div>
    </div>
  </v-box>
</template>

<script>
  import VBox from './VBox'

  export default {
    name: 'AddComment',

    components: {VBox},

    props: {
      commentUrl: {
        required: true
      },

      isReply: {
        type: Boolean,
        default: false
      }
    },

    data () {
      return {
        text: ''
      }
    },

    computed: {
      btnDisabled () {
        return this.text === ''
      }
    },

    methods: {
      submit () {
        if (this.text !== ' ') {
          axios.post('/api/comments', this.formatData())
            .then(resp => {
              this.$emit('comment-added', {
                comment: resp.data,
                isReply: this.isReply
              })

              this.text = ''
            })
            .catch(err => console.log(err))
        }
      },

      formatData () {
        let data = {
          user_id: App.user.id,
          body: this.text
        }

        data[this.isReply ? 'reply_id' : 'page_id'] = this.commentUrl

        return data
      }
    },
  }
</script>
