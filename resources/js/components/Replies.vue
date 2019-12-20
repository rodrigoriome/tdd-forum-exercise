<template>
  <div>
    <div v-for="(reply, index) in items" :key="index">
      <reply :data="reply" @deleted="remove(index)" />
    </div>
    <new-reply :endpoint="endpoint" @created="add" />
  </div>
</template>

<script>
import Reply from "./Reply";
import NewReply from "./NewReply";

export default {
  components: {
    Reply,
    NewReply
  },
  props: ["data"],
  data() {
    return {
      items: this.data,
      endpoint: `${location.pathname}/replies`
    };
  },
  methods: {
    add(reply) {
      this.items.push(reply);
      this.$emit("added");
    },
    remove(index) {
      this.items.splice(index, 1);
      this.$emit("removed");
    }
  }
};
</script>
