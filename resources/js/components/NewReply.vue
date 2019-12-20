<template>
  <div>
    <hr />
    <div v-if="signedIn">
      <div class="form-group">
        <textarea
          class="form-control"
          name="body"
          rows="5"
          placeholder="Have something to say?"
          v-model="body"
        ></textarea>
      </div>
      <button type="submit" class="btn btn-primary mb-2" @click="addReply">
        Reply
      </button>
    </div>
    <p v-else>
      Please <a href="/login">sign in</a> to participate in this discussion.
    </p>
  </div>
</template>

<script>
export default {
  props: ["endpoint"],
  data() {
    return {
      body: null
    };
  },
  computed: {
    signedIn() {
      return window.App.signedIn;
    }
  },
  methods: {
    addReply() {
      axios.post(this.endpoint, { body: this.body }).then(({ data }) => {
        this.body = "";
        flash("Your reply has been published.");
        this.$emit("created", data);
      });
    }
  }
};
</script>
