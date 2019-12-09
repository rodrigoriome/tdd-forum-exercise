<template>
  <div
    class="alert alert-success alert-dismissible fade show"
    role="alert"
    v-show="show"
  >
    <strong>Success!</strong> {{ body }}
  </div>
</template>

<script>
export default {
  props: ["message"],
  data() {
    return {
      body: "",
      show: false
    };
  },
  created() {
    if (this.message) {
      this.flash(this.message);
    }

    EventBus.$on("flash", this.onFlash);
  },

  methods: {
    flash(message) {
      this.body = message;
      this.show = true;

      this.hide();
    },

    hide() {
      setTimeout(() => {
        this.show = false;
      }, 3000);
    },

    onFlash(message) {
      this.flash(message);
    }
  }
};
</script>

<style lang="scss" scoped>
.alert {
  position: fixed;
  right: 25px;
  bottom: 25px;
}
</style>
