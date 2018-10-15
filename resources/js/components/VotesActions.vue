<template>
  <div>
    <span v-if="$signedIn && !voted" class="mr-1">
      <a href="#" @click.prevent="vote('up')">
        <i class="fas fa-thumbs-up"></i>
      </a>
      |
      <a href="#" @click.prevent="vote('down')">
        <i class="fas fa-thumbs-down"></i>
      </a>
    </span>

    <span class="small">Votes: {{ votes }}</span>
  </div>
</template>

<script>
  export default {
    name: 'VotesActions',

    props: ['votes', 'voted'],

    methods: {
      vote (type) {
        this.$emit('vote', type)
      }
    },
  }
</script>

<style scoped>
  .fa-thumbs-up {
    color: green
  }

  .fa-thumbs-down {
    color: red
  }
</style>
