<template>
  <div>
    <div v-for="(reply, index) in items" :key="reply.id">
      <reply :data="reply" @deleted="remove(index)" />
    </div>
    <paginator :dataSet="dataSet" @changed="fetch" />
    <new-reply :endpoint="endpoint" @created="add" />
  </div>
</template>

<script>
import Reply from "./Reply";
import NewReply from "./NewReply";
import Paginator from "./Paginator";
import Collection from "../mixins/Collection";

export default {
  components: {
    Reply,
    NewReply,
    Paginator
  },

  mixins: [Collection],

  data() {
    return {
      dataSet: null,
      endpoint: `${location.pathname}/replies`
    };
  },

  methods: {
    fetch(page) {
      if (!page) {
        const query = location.search.match(/page=(\d+)/);

        page = query ? query[1] : 1;
      }

      const url = page ? `${this.endpoint}?page=${page}` : this.endpoint;

      axios.get(url).then(this.refresh);
    },
    refresh({ data }) {
      this.dataSet = data;
      this.items = data.data;
    }
  },

  created() {
    this.fetch();
  }
};
</script>
