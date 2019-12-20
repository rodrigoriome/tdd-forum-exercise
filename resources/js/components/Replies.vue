<template>
  <div>
    <div v-for="(reply, index) in items" :key="index">
      <reply :data="reply" @deleted="remove(index)" />
    </div>
  </div>
</template>

<script>
import Reply from "./Reply";

export default {
  components: {
    Reply
  },
  props: ["data"],
  data() {
    return {
      items: this.data
    };
  },
  methods: {
    remove(index) {
      this.items.splice(index, 1);
      this.$emit("removed");
    }
  }
};
</script>
