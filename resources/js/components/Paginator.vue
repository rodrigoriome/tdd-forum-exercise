<template>
  <nav v-if="shouldPaginate">
    <ul class="pagination">
      <li class="page-item" v-if="prevUrl">
        <button class="page-link" @click="page--">Previous</button>
      </li>
      <li
        :class="{ 'page-item': true, active: n == page }"
        v-for="n in pages"
        :key="n"
      >
        <button class="page-link" @click="page = n">{{ n }}</button>
      </li>
      <li class="page-item" v-if="nextUrl">
        <button class="page-link" @click="page++">Next</button>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  props: ["dataSet"],

  data() {
    return {
      page: null,
      pages: null,
      prevUrl: null,
      nextUrl: null
    };
  },

  watch: {
    dataSet() {
      this.page = this.dataSet.current_page;
      this.pages = this.dataSet.total;
      this.prevUrl = this.dataSet.prev_page_url;
      this.nextUrl = this.dataSet.next_page_url;
    },
    page() {
      this.broadcast();
      this.updateUrl();
    }
  },

  computed: {
    shouldPaginate() {
      return this.prevUrl || this.nextUrl ? true : false;
    }
  },

  methods: {
    broadcast() {
      return this.$emit("chnaged", this.page);
    },
    updateUrl() {
      history.pushState(null, null, `?page=${this.page}`);
    }
  }
};
</script>
