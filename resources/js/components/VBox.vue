<template>
  <div class="row">
    <div class="col-md-1 col-sm-2 text-center pr-1">
      <img class="mx-auto rounded-circle img-fluid"
           src="/avatar/noavatar.png"
           alt="avatar"
      >
    </div>

    <slot></slot>
  </div>

</template>

<script>
  export default {
    name: 'VBox'
  }
</script>
