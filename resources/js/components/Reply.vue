<template>
  <div class="card my-3" :id="`reply-${data.id}`">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center">
        <span>
          <a :href="`/profiles/${data.owner.name}`">
            {{ data.owner.name }}
          </a>
          said {{ data.created_at }}
        </span>
        <span class="ml-auto" v-if="signedIn">
          <favorite :reply="data" />
        </span>
      </div>
    </div>
    <div class="card-body">
      <div v-if="editing">
        <div class="form-group">
          <textarea class="form-control" v-model="body"></textarea>
        </div>
        <button class="btn btn-sm btn-primary" @click="update">Update</button>
        <button class="btn btn-sm btn-link" @click="editing = false">
          Cancel
        </button>
      </div>
      <div v-else v-html="body"></div>
    </div>
    <div class="card-footer d-flex" v-if="canUpdate">
      <button
        type="submit"
        class="btn btn-sm btn-outline-primary mr-3"
        @click="editing = true"
      >
        Edit
      </button>
      <button type="submit" class="btn btn-sm btn-danger" @click="destroy">
        Delete
      </button>
    </div>
  </div>
</template>

<script>
import Favorite from "./Favorite";

export default {
  components: {
    Favorite
  },
  props: ["data"],
  data() {
    return {
      editing: false,
      body: this.data.body
    };
  },
  computed: {
    signedIn() {
      return window.App.signedIn;
    },
    canUpdate() {
      return this.authorize(user => this.data.user_id == user.id);
    }
  },
  methods: {
    update() {
      axios
        .patch(`/replies/${this.data.id}`, {
          body: this.body
        })
        .then(response => {
          this.editing = false;
          flash("Reply updated.");
        });
    },
    destroy() {
      axios.delete(`/replies/${this.data.id}`).then(({ data }) => {
        this.$emit("deleted", this.data.id);
        flash(data.status);
      });
    }
  }
};
</script>
